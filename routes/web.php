<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/contratos/public/livewire/livewire.js', $handle);
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/contratos/public/livewire/update', $handle);
});

Route::get('/', function () {
    return redirect('/admin/login');
});

// OK
Route::get('/ConsultarLoteRps', function () {

    $ns = 'http://saofranciscodeassis.govbr.cloud/NFSe.Portal.Integracao/Services.svc';
    $wsdl = $ns . '?wsdl';

    $options = [
        'trace' => 1,  // Habilita o rastreamento das requisições e respostas para depuração
        'exceptions' => true,  // Lança exceções em caso de erro
        'soap_version' => SOAP_1_1,  // Força o uso da versão SOAP 1.1
        'cache_wsdl' => WSDL_CACHE_NONE, // Desativa o cache da WSDL para garantir que esteja usando a versão mais recente
    ];

    $xml = '<ConsultarLoteRpsEnvio>
                <Prestador>
                    <CpfCnpj>
                        <Cnpj>94771615000165</Cnpj>
                    </CpfCnpj>
                    <InscricaoMunicipal>2542</InscricaoMunicipal>
                </Prestador>
                <Protocolo>023b2823-c83b-4e10-a886-360ec37507ca</Protocolo>
            </ConsultarLoteRpsEnvio>';

    $client = new \SoapClient($wsdl);

    try {
        $header = new SoapHeader('http://tempuri.org/', 'cabecalho', array('versaoDados' => '2.03'));

        $client = new SoapClient($wsdl, $options);
        $client->__setSoapHeaders($header);

        $arguments = array('xmlEnvio' => $xml);

        $response =  $client->ConsultarLoteRps($arguments);

        dd($response);
    } catch (\SoapFault $fault) {
        dd($fault->getMessage());
    }
});

Route::get('/ConsultarNfsePorRps', function () {

    $ns = 'http://saofranciscodeassis.govbr.cloud/NFSe.Portal.Integracao/Services.svc';
    $wsdl = $ns . '?wsdl';

    $options = [
        'trace' => 1,  // Habilita o rastreamento das requisições e respostas para depuração
        'exceptions' => true,  // Lança exceções em caso de erro
        'soap_version' => SOAP_1_1,  // Força o uso da versão SOAP 1.1
        'cache_wsdl' => WSDL_CACHE_NONE, // Desativa o cache da WSDL para garantir que esteja usando a versão mais recente
    ];

    $xml = '<ConsultarNfseRpsEnvio>
                <IdentificacaoRps>
                    <Numero>200</Numero>
                    <Serie>14</Serie>
                    <Tipo>1</Tipo>
                </IdentificacaoRps>
                <Prestador>
                    <CpfCnpj>
                        <Cnpj>94771615000165</Cnpj>
                    </CpfCnpj>
                </Prestador>
            </ConsultarNfseRpsEnvio>';

    $client = new \SoapClient($wsdl);

    try {
        $arr = array('versao' => '2.03', 'versaoDados' => '2.03');

        $header = new SoapHeader('http://tempuri.org/', 'cabecalho', $arr);

        $client = new SoapClient($wsdl, $options);
        $client->__setSoapHeaders($header);

        $arguments = array('xmlEnvio' => $xml);

        $response =  $client->ConsultarNfsePorRps($arguments);

        dd($response);
    } catch (\SoapFault $fault) {
        dd($fault->getMessage());
    }
});


Route::get('/enviar', function () {

    $ns = 'http://saofranciscodeassis.govbr.cloud/NFSe.Portal.Integracao/Services.svc';
    $wsdl = $ns . '?wsdl';

    $options = [
        'trace' => 1,  // Habilita o rastreamento das requisições e respostas para depuração
        'exceptions' => true,  // Lança exceções em caso de erro
        'soap_version' => SOAP_1_1,  // Força o uso da versão SOAP 1.1
        'cache_wsdl' => WSDL_CACHE_NONE, // Desativa o cache da WSDL para garantir que esteja usando a versão mais recente
    ];

    $xml =
        '<EnviarLoteRpsEnvio>
            <LoteRps Id="lote:1" versao="2.03">
                <NumeroLote>1</NumeroLote>
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
                                    <Numero>1</Numero>
                                    <Serie>1</Serie>
                                    <Tipo>1</Tipo>
                                </IdentificacaoRps>
                                <DataEmissao>2024-08-20</DataEmissao>
                                <Status>1</Status>
                            </Rps>
                            <Competencia>2024-08-20</Competencia>
                            <Servico>
                                <Valores>
                                    <ValorServicos>0.01</ValorServicos>
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
                                <ItemListaServico>01.04</ItemListaServico>
                                <CodigoCnae>6202300</CodigoCnae>
                                <CodigoTributacaoMunicipio>6202300</CodigoTributacaoMunicipio>
                                <Discriminacao>VALOR REFERENTE LOCAÇÃO DE SISTEMA DE MARCA E SINAL CFE
                                    CONTRATO 45/2023
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
                                        <Cnpj>88201298000149</Cnpj>
                                    </CpfCnpj>
                                </IdentificacaoTomador>
                                <RazaoSocial>MUNICIPIO DE LAVRAS DO SUL</RazaoSocial>
                                <Endereco>
                                    <Endereco>CORONEL MESA</Endereco>
                                    <Numero>373</Numero>
                                    <Complemento>PREDIO</Complemento>
                                    <Bairro>CENTRO</Bairro>
                                    <CodigoMunicipio>4311502</CodigoMunicipio>
                                    <Uf>RS</Uf>
                                    <Cep>97390000</Cep>
                                </Endereco>
                                <Contato>
                                    <Telefone>5532821244</Telefone>
                                    <Email>meiorurallavrasdosul@gmail.com</Email>
                                </Contato>
                            </Tomador>
                            <OptanteSimplesNacional>1</OptanteSimplesNacional>
                            <IncentivoFiscal>2</IncentivoFiscal>
                        </InfDeclaracaoPrestacaoServico>
                    </Rps>
                </ListaRps>
            </LoteRps>
        </EnviarLoteRpsEnvio>';

    try {
        $arr = array([
            'versaoDados' => '2.03'
        ]);

        $header = new SoapHeader('http://tempuri.org/', 'cabecalho', $arr);

        $client = new SoapClient($wsdl, $options);
        $client->__setSoapHeaders($header);

        $arguments = array('xmlEnvio' => $xml);

        $response = $client->RecepcionarLoteRps($arguments);
        // $response = $client->EnviarLoteRpsSincrono($arguments);
        dd($response);
    } catch (\SoapFault $fault) {
        dd($fault->getMessage());
    }
});
