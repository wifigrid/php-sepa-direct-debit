<?php
function create_sepa($input) {
        if ($input['begunstigde']['batch'] === 'FRST') {
                $uitvoerdatum = date('Y-m-d', strtotime("+1 week"));
        } else {
                $uitvoerdatum = date('Y-m-d', strtotime("+3 days"));
        }
        $aantal = count($input['opdrachten']);
        $totaalbedrag = 0;
        foreach ($input['opdrachten'] as $value) {
                $totaalbedrag = $totaalbedrag + $value['bedrag'];
        }
        $content = '<?xml version="1.0" encoding="UTF-8"?>
<Document xmlns="urn:iso:std:iso:20022:tech:xsd:pain.008.001.02" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
<CstmrDrctDbtInitn>
        <GrpHdr>
                <MsgId>'.date('YmdHis').$input['begunstigde']['batch'].'</MsgId>
                <CreDtTm>'.substr(date('c'),0,19).'</CreDtTm>
                <NbOfTxs>'.$aantal.'</NbOfTxs>
                <CtrlSum>'.number_format($totaalbedrag,2).'</CtrlSum>
                <InitgPty><Nm>'.$input['begunstigde']['bedrijfsnaam'].'</Nm></InitgPty>
        </GrpHdr>
        <PmtInf>
                <PmtInfId>'.date('YmdHis').$input['begunstigde']['batch'].'</PmtInfId>
                <PmtMtd>DD</PmtMtd>
                <NbOfTxs>'.$aantal.'</NbOfTxs>
                <CtrlSum>'.$totaalbedrag.'</CtrlSum>
                <PmtTpInf>
                        <SvcLvl><Cd>SEPA</Cd></SvcLvl>
                        <LclInstrm><Cd>'.$input['begunstigde']['soort'].'</Cd></LclInstrm>
                        <SeqTp>'.$input['begunstigde']['batch'].'</SeqTp>
                </PmtTpInf>
                <ReqdColltnDt>'.$uitvoerdatum.'</ReqdColltnDt>
                <Cdtr>
                        <Nm>'.$input['begunstigde']['bedrijfsnaam'].'</Nm>
                        <PstlAdr>
                                <Ctry>'.$input['begunstigde']['land'].'</Ctry>
                                <AdrLine>'.$input['begunstigde']['adres1'].'</AdrLine>
                                <AdrLine>'.$input['begunstigde']['adres2'].'</AdrLine>
                        </PstlAdr>
                </Cdtr>
                <CdtrAcct>
                        <Id><IBAN>'.$input['begunstigde']['iban'].'</IBAN></Id><Ccy>EUR</Ccy>
                </CdtrAcct>
                <CdtrAgt><FinInstnId><BIC>'.$input['begunstigde']['bic'].'</BIC></FinInstnId></CdtrAgt>
                <ChrgBr>SLEV</ChrgBr>
';
        foreach ($input['opdrachten'] as $opdracht) {
                $content .= '           <DrctDbtTxInf>
                        <PmtId>
                                <InstrId>'.$opdracht['transactieid'].'</InstrId>
                                <EndToEndId>'.$opdracht['transactieid'].'</EndToEndId>
                        </PmtId>
                        <InstdAmt Ccy="EUR">'.$opdracht['bedrag'].'</InstdAmt>
                        <DrctDbtTx>
                                <MndtRltdInf>
                                        <MndtId>'.$opdracht['mandaatkenmerk'].'</MndtId>
                                        <DtOfSgntr>'.$opdracht['mandaatdatum'].'</DtOfSgntr>
                                </MndtRltdInf>
                                <CdtrSchmeId>
                                        <Id>
                                                <PrvtId>
                                                        <Othr>
                                                                <Id>'.$input['begunstigde']['incassantid'].'</Id>
                                                                <SchmeNm>
                                                                        <Prtry>SEPA</Prtry>
                                                                </SchmeNm>
                                                        </Othr>
                                                </PrvtId>
                                        </Id>
                                </CdtrSchmeId>
                        </DrctDbtTx>
                                <DbtrAgt><FinInstnId><BIC>'.$opdracht['bic'].'</BIC></FinInstnId></DbtrAgt>
                                <Dbtr>
                                        <Nm>'.$opdracht['bedrijfsnaam'].'</Nm>
                                        <PstlAdr>
                                                <Ctry>'.$opdracht['land'].'</Ctry>
                                                <AdrLine>'.$opdracht['adres1'].'</AdrLine>
                                                <AdrLine>'.$opdracht['adres2'].'</AdrLine>
                                        </PstlAdr>
                                </Dbtr>
                        <DbtrAcct>
                                <Id><IBAN>'.$opdracht['iban'].'</IBAN></Id>
                        </DbtrAcct>
                        <Purp><Cd>OTHR</Cd></Purp>
                        <RmtInf>
                                <Ustrd>'.$opdracht['omschrijving'].'</Ustrd>
                        </RmtInf>
                </DrctDbtTxInf>
';
}

        $content .= '   </PmtInf>
</CstmrDrctDbtInitn>
</Document>';
        return $content;
}
?>