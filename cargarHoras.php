<?php

/* jira-log-work-emacs-diary
 * Fabrizio Di Pilla <fdipilla@gnu.org> 
 * 2013
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */


class CargarHoras {

    
    private $username;
    
    private $password;
    
    private $url;

    private $proyect;
	

    private $diaryFile;
        
    

    function __construct(){
        
        $this->username  = 'XXXXXXX';
        
        $this->password  = 'XXXXXX';
        
        $this->proyect   = 'XXX';
	
        $this->url       = "https://some.domain/rest/tempo-rest/1.0/worklogs/{$this->proyect}";
	
        $this->diaryFile = "path/to/diary";
    }
    
    
    
    function justDoIt(){
        $this->postData();
    }
    
    
    
    function postData(){
        
        $thisMonthLastDay = date("t/M/y",strtotime('yesterday'));
        
        $logEntrys = $this->getArrayDiaryLog();
        
        foreach($logEntrys as $logEntry){
            
            $curl = curl_init();
            echo $logEntry['date'] . "\n";
            $vars  = "comment={$logEntry['comment']}";
            $vars .= "&date={$logEntry['date']}";
            $vars .= "&enddate={$thisMonthLastDay}";
            $vars .= '&id=';
            $vars .= "&issue={$this->proyect}";
            $vars .= '&planning=false&remainingEstimate=0h&selected-panel=0&startTimeEnabled=false&time=8&tracker=false&type=';
            $vars .= "&user={$this->username}";
            
            curl_setopt($curl, CURLOPT_USERPWD, "{$this->username}:{$this->password}");
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $vars);
            
            $response = (curl_exec($curl));
            
        }
    }

    
    
    function getArrayDiaryLog(){
        $file = fopen($this->diaryFile, "r") or exit("Unable to open file!");
        
        //Output a line of the file until the end is reached        
        $arrayDiaryLog    = Array();
        $lastMont = date("m/Y",strtotime('last month'));
    
        while ( !feof($file) ) {
            
            $line = fgets($file);
            
            $lineArray = explode(' ', $line);
            
            $lineDate     = date("d-m-Y",strtotime($lineArray[0] . $lineArray[1] . $lineArray[2]));
            $lineMonth    = date("m/Y",strtotime($lineArray[0] . $lineArray[1] . $lineArray[2] ));
            
            $lineArray[0] = $lineArray[1] = $lineArray[2] = '';
            
            $lineContent  = implode(' ',$lineArray);
            
            
            
            if ( $lineMonth == $lastMont ) {
            	
                $arrayDiaryLog[$lineDate]['comment'] .= $lineContent . "\n";
                
                $date = new DateTime($lineDate);
                
                $arrayDiaryLog[$lineDate]['date']  =  $date->format('d/M/y');
            }
            
        }
        
        fclose($file);
        
        return $arrayDiaryLog;
        
    }
}





$dumb = new CargarHoras;

$dumb->justDoIt();


?>
