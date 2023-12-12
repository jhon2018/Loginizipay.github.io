<?php
	class Config {
        public function ConfigPhp($ConfiValue){
            return $this->ConfigPhp2($ConfiValue);
        }
		private static function ConfigPhp2($ValueConfi){
            $ReturnValue = false;
            switch ($ValueConfi) {
                case "wwwRot":
                    $ReturnValue = "http://localhost:8089/HerramientaGestionEncuestas/";
                    break;
                case "ServerDatabase":
                    $ReturnValue = "COLBOGSQLD16\MSSQLD162017";
                    break;
                case "NameDatabase":
                    $ReturnValue = "ATENTO_SURVEY_TOOLS_SOLUCIONES_RPA";
                    break;
                case "UserDatabase":
                    $ReturnValue = "ate_survey";
                    break;
                case "PassDateBase":
                    $ReturnValue = "ate_survey";
                    break;
                case "KeyHashEncript":
                    $ReturnValue = "Survey_Tools_Panda_2023_Atento_Soluciones";
                    break;
                case "ProxyConfigSettings":
                    $ReturnValue = "proxy_admin:3130";
                    break;
                default:
                    $ReturnValue = false;
                    break;
            }
			return $ReturnValue;
		}
	}
    unset($ConfigPHP);	
?>