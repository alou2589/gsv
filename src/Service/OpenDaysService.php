<?php
    namespace App\Service;
    
    class OpenDaysService {
        
        public function getOpenDays($date_depart, $date_fin) {
            $joursFériésFixes= array();
            
            $diff_year= date('Y', $date_depart)- date('Y',$date_fin);
            for($i=0; $i<= $diff_year; $i++){
                $joursFériésFixes[] = '1_1_'.date('Y'); // Jour de l'an
                $joursFériésFixes[] = '4_4_'.date('Y'); // Fête de l'indépendance
                $joursFériésFixes[] = '1_5_'.date('Y'); // Fete du travail
                $joursFériésFixes[] = '15_8_'.date('Y'); // Assomption
                $joursFériésFixes[] = '1_11_'.date('Y'); // Toussaint
                $joursFériésFixes[] = '25_12_'.date('Y'); // Noel
                
                
                $easter= easter_date(date('Y'));
                
                $joursFériésFixes[] = date('j_n_'.date('Y'), $easter + 86400); //Pâcques
                $joursFériésFixes[] = date('j_n_'.date('Y'), $easter + 86400*39); //Ascencion
            }
            $nb_days_open = 0; 
            while ($date_depart < $date_fin) {
                // Si le jour suivant n'est ni un dimanche (0) ou un samedi (6), ni un jour férié, on incrémente les jours ouvrés
         
                if (in_array(date('w', $date_depart) , array(0,6))) {
                    $nb_days_open=$nb_days_open;
                } elseif(in_array(date('j_n_' . date('Y', $date_depart) , $date_depart) , $joursFériésFixes)) {
                    $nb_days_open=$nb_days_open;
                } else {
                    $nb_days_open++;
                }
                $date_depart+= 86400;
            }
            $nb_days_open++;
            
            
           return $nb_days_open;
        }
        
        public function calculJoursFeries($mois) {
 
            $nbJourMois = cal_days_in_month(CAL_GREGORIAN, $mois, date('Y'));
         
         
             $date_depart = strtotime(strval (date('Y'))."-".strval ($mois)."-".strval (1));
             $date_fin = strtotime(strval (date('Y'))."-".strval ($mois)."-".strval ($nbJourMois));
             $nbOpenDays = self::getOpenDays($date_depart, $date_fin);
             
             return $nbOpenDays;
        }
}