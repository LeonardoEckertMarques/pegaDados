<?php

@header('Content-Type: text/html; charset=UTF-8');

$arquivos = [];
$comp = [];
$dir = "./xml";

if (is_dir($dir)) {
	if ($diretorio = opendir($dir)) {
		while (($arquivo = readdir($diretorio)) !== false) {
			if ($arquivo != "." && $arquivo != "..") {
				array_push($arquivos, simplexml_load_file($dir."/".$arquivo));
			}
		}
		closedir($diretorio);
	}
	
	for ($i=0; $i < count($arquivos); $i++) {
		array_push($comp, substr($arquivos[$i]->Nfse->InfNfse->Competencia->__toString(), 0, 7));
		$resultado[$comp[$i]]["ValorServicos"] += $arquivos[$i]->Nfse->InfNfse->Servico->Valores->ValorServicos->__toString();
		$resultado[$comp[$i]]["ValorIss"] += $arquivos[$i]->Nfse->InfNfse->Servico->Valores->ValorIss->__toString();
		$resultado[$comp[$i]]["ValorIssRetido"] += $arquivos[$i]->Nfse->InfNfse->Servico->Valores->ValorIssRetido->__toString();
		$resultado[$comp[$i]]["OutrasRetencoes"] += $arquivos[$i]->Nfse->InfNfse->Servico->Valores->OutrasRetencoes->__toString();
		$resultado[$comp[$i]]["BaseCalculo"] += $arquivos[$i]->Nfse->InfNfse->Servico->Valores->BaseCalculo->__toString();
		$resultado[$comp[$i]]["ValorLiquidoNfse"] += $arquivos[$i]->Nfse->InfNfse->Servico->Valores->ValorLiquidoNfse->__toString();
	}

	ksort($resultado);

}

?>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Competência</th>
			<th>ValorServicos</th>
			<th>ValorIss</th>
			<th>ValorIssRetido</th>
			<th>OutrasRetencoes</th>
			<th>BaseCalculo</th>
			<th>Aliquota</th>
			<th>ValorLiquidoNfse</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($resultado as $chave => $valor) { ?>
		<tr>
			<td><?php echo $chave; ?></td>
			<td><?php echo $valor[ValorServicos]; ?></td>
			<td><?php echo $valor[ValorIss]; ?></td>
			<td><?php echo $valor[ValorIssRetido]; ?></td>
			<td><?php echo $valor[OutrasRetencoes]; ?></td>
			<td><?php echo $valor[BaseCalculo]; ?></td>
			<td><?php echo $valor[Aliquota] =  round((($valor[ValorIss]/$valor[ValorServicos])*100), 2) ;?></td>
			<td><?php echo $valor[ValorLiquidoNfse]; ?></td>
		</tr>
	<?php	} ?>
	</tbody>
</table>