<?php

namespace App\Filament\Resources\SendingResource\Pages;

use App\Filament\Resources\SendingResource;
use App\Models\Cnae;
use App\Models\Contract;
use Exception;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use SoapClient;
use SoapHeader;

class CreateSending extends CreateRecord
{
    protected static string $resource = SendingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $cnae = Cnae::find($data['cnae_id']);
        $contract = Contract::find($data['contract_id']);

        $cnpjTomador = preg_replace('/[^0-9]/', '', $contract->client->cpf_cnpj);
        $cep = str_replace('-', '', $contract->client->address->postal_code);
        $phone = str_replace(['-', '(', ')'], '', $contract->client->phone);
        
        $street = $contract->client->address->street ? $contract->client->address->street : '.';
        $number = $contract->client->address->number ? $contract->client->address->number : '.';
        $complement = $contract->client->address->complement ? $contract->client->address->complement : '.';
        $district = $contract->client->address->district ? $contract->client->address->district : '.';
        $state = $contract->client->address->state ? $contract->client->address->state : 'RS';

        $ns = 'http://saofranciscodeassis.govbr.cloud/NFSe.Portal.Integracao/Services.svc';
        $wsdl = $ns . '?wsdl';

        $options = [
            'trace' => 1,  // Habilita o rastreamento das requisições e respostas para depuração
            'exceptions' => true,  // Lança exceções em caso de erro
            'soap_version' => SOAP_1_1,  // Força o uso da versão SOAP 1.1
            'cache_wsdl' => WSDL_CACHE_NONE, // Desativa o cache da WSDL para garantir que esteja usando a versão mais recente
        ];

        $xml =
            "<EnviarLoteRpsEnvio>
                <LoteRps Id='lote:1' versao='2.03'>
                    <NumeroLote>{$data['rps']}</NumeroLote>
                    <CpfCnpj>
                        <Cnpj>94771615000165</Cnpj>
                    </CpfCnpj>
                    <InscricaoMunicipal>2542</InscricaoMunicipal>
                    <QuantidadeRps>1</QuantidadeRps>
                    <ListaRps>
                        <Rps>
                            <InfDeclaracaoPrestacaoServico>
                                <Rps>
                                    <IdentificacaoRps>
                                        <Numero>{$data['rps']}</Numero>
                                        <Serie>{$data['rps']}</Serie>
                                        <Tipo>1</Tipo>
                                    </IdentificacaoRps>
                                    <DataEmissao>{$data['emission_date']}</DataEmissao>
                                    <Status>1</Status>
                                </Rps>
                                <Competencia>{$data['competence_date']}</Competencia>
                                <Servico>
                                    <Valores>
                                        <ValorServicos>{$data['value']}</ValorServicos>
                                        <ValorPis>0.00</ValorPis>
                                        <ValorCofins>0.00</ValorCofins>
                                        <ValorInss>0.00</ValorInss>
                                        <ValorIr>0.00</ValorIr>
                                        <ValorCsll>0.00</ValorCsll>
                                        <ValorIss>0.00</ValorIss>
                                        <Aliquota>0.00</Aliquota>
                                        <DescontoIncondicionado>0.00</DescontoIncondicionado>
                                        <DescontoCondicionado>0.00</DescontoCondicionado>
                                    </Valores>
                                    <IssRetido>2</IssRetido>
                                    <ItemListaServico>{$cnae->number}</ItemListaServico>
                                    <CodigoCnae>{$cnae->code}</CodigoCnae>
                                    <CodigoTributacaoMunicipio>6202300</CodigoTributacaoMunicipio>
                                    <Discriminacao>{$data['info']}
                                    </Discriminacao>
                                    <CodigoMunicipio>4318101</CodigoMunicipio>
                                    <CodigoPais>1058</CodigoPais>
                                    <ExigibilidadeISS>1</ExigibilidadeISS>
                                    <MunicipioIncidencia>4318101</MunicipioIncidencia>
                                </Servico>
                                <Prestador>
                                    <CpfCnpj>
                                        <Cnpj>94771615000165</Cnpj>
                                    </CpfCnpj>
                                    <InscricaoMunicipal>2542</InscricaoMunicipal>
                                </Prestador>
                                <Tomador>
                                    <IdentificacaoTomador>
                                        <CpfCnpj>
                                            <Cnpj>{$cnpjTomador}</Cnpj>
                                        </CpfCnpj>
                                    </IdentificacaoTomador>
                                    <RazaoSocial>{$contract->client->name}</RazaoSocial>
                                    <Endereco>
                                        <Endereco>{$street}</Endereco>
                                        <Numero>{$number}</Numero>
                                        <Complemento>{$complement}</Complemento>
                                        <Bairro>{$district}</Bairro>
                                        <CodigoMunicipio>{$contract->client->ibge_code}</CodigoMunicipio>
                                        <Uf>{$state}</Uf>
                                        <Cep>{$cep}</Cep>
                                    </Endereco>
                                    <Contato>
                                        <Telefone>{$phone}</Telefone>
                                        <Email>{$contract->client->email}</Email>
                                    </Contato>
                                </Tomador>
                                <OptanteSimplesNacional>1</OptanteSimplesNacional>
                                <IncentivoFiscal>2</IncentivoFiscal>
                            </InfDeclaracaoPrestacaoServico>
                        </Rps>
                    </ListaRps>
                </LoteRps>
            </EnviarLoteRpsEnvio>";

        $arr = array([
            'versaoDados' => '2.03'
        ]);

        $header = new SoapHeader('http://tempuri.org/', 'cabecalho', $arr);
        $client = new SoapClient($wsdl, $options);
        $client->__setSoapHeaders($header);
        $arguments = array('xmlEnvio' => $xml);
        $response = $client->RecepcionarLoteRps($arguments);

        $xml = simplexml_load_string($response->RecepcionarLoteRpsResult);
        $dataArray = json_decode(json_encode($xml), true);

        // dd($dataArray);

        if (isset($dataArray['ListaMensagemRetorno'])) {
            foreach ($dataArray['ListaMensagemRetorno']['MensagemRetorno'] as $key => $message) {
                Notification::make()
                    ->title('Erro')
                    ->body($message)
                    ->danger()
                    ->send();

                throw new Exception($message['Correcao']);
            }
        }

        $data['situation'] = 1;
        $data['number'] = $dataArray['NumeroLote'];
        $dateTime = $dataArray['DataRecebimento'];
        $data['date'] = str_replace('T', ' ', $dateTime);
        $data['protocol'] = $dataArray['Protocolo'];

        return $data;
    }
}
