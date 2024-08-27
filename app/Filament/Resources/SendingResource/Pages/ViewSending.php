<?php

namespace App\Filament\Resources\SendingResource\Pages;

use App\Filament\Resources\SendingResource;
use App\Models\Cnae;
use App\Models\Sending;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;
use SoapClient;
use SoapHeader;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\Storage;

class ViewSending extends ViewRecord
{
    protected static string $resource = SendingResource::class;

    public $nfse = [];

    protected function getActions(): array
    {
        return [
            Action::make('downloadPdf')
                ->label('Download NFSe')
                ->action('downloadPdf')
                ->visible(fn() => $this->record->situation === 4)
                ->color('primary'),
        ];
    }

    public function downloadPdf()
    {
        dd($this->nfse);
        $generator = new BarcodeGeneratorPNG();
        $identifier = $this->nfse['Numero'] . $this->nfse['CodigoVerificacao'] . $this->nfse['PrestadorServico']['IdentificacaoPrestador']['CpfCnpj']['Cnpj'];
        $this->nfse['identifier'] = $identifier;
        $barcode = $generator->getBarcode($identifier, $generator::TYPE_CODE_128);
        Storage::disk('public')->put("barcodes/{$identifier}.png", $barcode);

        $dateString = $this->nfse['DataEmissao'];
        $this->nfse['DataEmissao'] = Carbon::parse($dateString)->format('d/m/Y');

        $ibgeCode = $this->nfse['DeclaracaoPrestacaoServico']['InfDeclaracaoPrestacaoServico']['Tomador']['Endereco']['CodigoMunicipio'];
        $apiUrl = "https://servicodados.ibge.gov.br/api/v1/localidades/municipios/{$ibgeCode}";
        $response = file_get_contents($apiUrl);
        $brasilApiData = json_decode($response, true);
        $this->nfse['DeclaracaoPrestacaoServico']['InfDeclaracaoPrestacaoServico']['Tomador']['Endereco']['NomeMunicipio'] = $brasilApiData['nome'];

        $cnae = Cnae::where('number', $this->nfse['DeclaracaoPrestacaoServico']['InfDeclaracaoPrestacaoServico']['Servico']['ItemListaServico'])->get()->first();
        $this->nfse['DeclaracaoPrestacaoServico']['InfDeclaracaoPrestacaoServico']['Servico']['Cnae'] = $cnae->description;

        $pdf = Pdf::loadView('pdf.nfse', ['nfse' => $this->nfse]);

        return response()->streamDownload(fn() => print($pdf->setPaper('a4', 'portrait')->output()), "nfse_{$this->nfse['Numero']}.pdf");
    }

    public function mount(int | string $record): void
    {
        parent::mount($record);

        $sending = Sending::find($record);

        $ns = 'http://saofranciscodeassis.govbr.cloud/NFSe.Portal.Integracao/Services.svc';
        $wsdl = $ns . '?wsdl';

        $options = [
            'trace' => 1,  // Habilita o rastreamento das requisições e respostas para depuração
            'exceptions' => true,  // Lança exceções em caso de erro
            'soap_version' => SOAP_1_1,  // Força o uso da versão SOAP 1.1
            'cache_wsdl' => WSDL_CACHE_NONE, // Desativa o cache da WSDL para garantir que esteja usando a versão mais recente
        ];

        $xml = "<ConsultarLoteRpsEnvio>
                <Prestador>
                    <CpfCnpj>
                        <Cnpj>94771615000165</Cnpj>
                    </CpfCnpj>
                    <InscricaoMunicipal>2542</InscricaoMunicipal>
                </Prestador>
                <Protocolo>{$sending->protocol}</Protocolo>
            </ConsultarLoteRpsEnvio>";

        // Protocolo que gerou NFSe
        // $xml = "<ConsultarLoteRpsEnvio>
        //     <Prestador>
        //         <CpfCnpj>
        //             <Cnpj>94771615000165</Cnpj>
        //         </CpfCnpj>
        //         <InscricaoMunicipal>2542</InscricaoMunicipal>
        //     </Prestador>
        //     <Protocolo>023b2823-c83b-4e10-a886-360ec37507ca</Protocolo>
        // </ConsultarLoteRpsEnvio>";

        $client = new \SoapClient($wsdl);

        $header = new SoapHeader('http://tempuri.org/', 'cabecalho', array('versaoDados' => '2.03'));

        $client = new SoapClient($wsdl, $options);
        $client->__setSoapHeaders($header);

        $arguments = array('xmlEnvio' => $xml);

        $response =  $client->ConsultarLoteRps($arguments);

        $xml = simplexml_load_string($response->ConsultarLoteRpsResult);
        $dataArray = json_decode(json_encode($xml), true);

        Sending::where('id', $sending->id)->update(['situation' => $dataArray['Situacao']]);

        if (isset($dataArray['ListaMensagemRetornoLote'])) {
            foreach ($dataArray['ListaMensagemRetornoLote'] as $key => $message) {
                Notification::make()
                    ->title($message['Codigo'])
                    ->body($message['Mensagem'])
                    ->danger()
                    ->duration(null)
                    ->send();
            }
        } else {
            if(isset($dataArray['ListaNfse']['CompNfse']['Nfse']['InfNfse'])){
                $this->nfse = $dataArray['ListaNfse']['CompNfse']['Nfse']['InfNfse'];
            }
        }
    }
}
