<?php
function preparar_query($conexionDB,$sqlprepare,$parametros=[],$types=""){
	$types=$types ?: str_repeat("s",count($parametros));
	$cmd=$conexionDB->prepare($sqlprepare);
	if($parametros!=[]) $cmd->bind_param($types, ...$parametros);
	$cmd->execute();
	return $cmd;
}
	function preparar_select($conexionDB,$sql,$parametros=[],$types=""){
	return preparar_query($conexionDB,$sql,$parametros,$types)->get_result();
}
?>