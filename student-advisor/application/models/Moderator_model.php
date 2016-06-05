<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moderator_model extends CI_Model {

    public function __construct()
    {
        $this->load->database();
    }
    public function index()
    {

    }
    public function get_clan_username($id)
    {
        $query = $this->db->get_where('clan', array('username' => $id));
        return $query->row_array()['idClan'];
    }
    public function get_clan($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->get('clan');
            return $query->result_array()[0];
        }

        $query = $this->db->get_where('clan', array('idClan' => $id));
        return $query->row_array();
    }
    public function get_kurs($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->get('kurs');
            return $query->result_array()[0];
        }

        $query = $this->db->get_where('kurs', array('idKurs' => $id));
        return $query->row_array();
    }
    public function get_predavac($idPred = FALSE)
    {
        if ($idPred === FALSE)
        {
            $query = $this->db->get('predavac');
            return $query->result_array()[0];
        }

        $query = $this->db->get_where('predavac', array('idPred' => $idPred));
        return $query->row_array();
    }

    public function get_kurs_komentar($id = 1)
    {
        $query = $this->db->query("select p.*, k.* FROM komentar p inner join kurs k on p.idKurs = k.idkurs and p.idKom=?", array($id));
        return $query->row_array();
    }
    public function get_kurs_predavac($idKurs = 1)
    {
        $query = $this->db->query("select p.*, k.* FROM predavac p inner join predaje k on p.idPred = k.idPred and k.idKurs=? ORDER BY p.zvanje DESC", array($idKurs));
        return $query->result_array();
    }
    public function get_clan_komentar($id, $myID)
    {
        $query = $this->db->query("select p.*, k.*, po.tip FROM komentar p inner join clan k left outer join podrzavanje po 
            on p.idClan = k.idClan and p.idKom=? and p.idClan=? and p.idKom=po.idKom", array($id, $myID));
        return $query->row_array();
    }
    public function get_podkomentar($id = 1)
    {
        $query = $this->db->query("select p.*, k.* FROM podkomentar p inner join clan k on p.idClan = k.idClan and p.idKom=?", array($id));
        return $query->result_array();
    }
    public function get_Polozio_clan($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("select p.*, k.* FROM polozio p inner join kurs k on p.idKurs = k.idkurs");
            return $query->result_array();
        }

        $query = $this->db->query('select p.*, k.* FROM polozio p inner join kurs k on p.idKurs = k.idkurs AND p.idClan=?',array($id));
        return $query->result_array();
    }
    public function get_Polozio_kurs($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("select p.*, k.* FROM polozio p inner join clan k on p.idClan = k.idClan");
            return $query->result_array();
        }

        $query = $this->db->query('select p.*, k.* FROM polozio p inner join clan k on p.idClan = k.idClan AND p.idKurs=?',array($id));
        return $query->result_array();
    }

    public function get_Polozio_kurs_zvezdice($idKurs, $myID)
    {
        $query = $this->db->query('select * FROM polozio where idClan = ? AND idKurs=?',array($myID, $idKurs));
        return $query->row_array();
    }
    public function  get_predaje_kurs($idPred=1)
    {
        $query = $this->db->query('select p.*, k.* FROM predaje p inner join kurs k on p.idKurs = k.idkurs AND p.idPred=?',array($idPred));
        return $query->result_array();
    }
    public function get_kurs_ocena($idClana = 1, $idKursa = 1)
    {
        $query = $this->db->get_where('polozio', array('idClan' => $idClana),array('idKurs'=>$idKursa));
        return $query->row_array();
    }



	public function get_Polozio1_kurs($id = FALSE)
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("select p.*, k.* FROM polozio p inner join clan k on p.idClan = k.idClan");
            return $query->result_array();
        }

        $query = $this->db->query("select p.*, k.*, ko.*
                                    FROM `student-advisor-mysql`.polozio p 
                                    inner join `student-advisor-mysql`.clan k  
                                    
                                    on p.idClan = k.idClan 
                                    AND p.zanimljivost AND p.tezina AND p.preporuka AND p.korisnost
                                    AND p.idKurs=?
                                    left join `student-advisor-mysql`.komentar ko 
                                    on ko.idClan=p.idClan and ko.idKurs=p.idKurs
"
            ,array($id));
        return $query->result_array();
    }
    public function get_Ocenio_kurs($id)
    {

        $query = $this->db->query("select p.*, k.*
                                    FROM polozio p 
                                    inner join clan k                                   
                                    on p.idClan = k.idClan 
                                    AND (p.zanimljivost OR p.tezina OR p.preporuka OR p.korisnost)
                                    AND p.idKurs=?",array($id));
        return $query->result_array();
    }


    public function find_komentar($idKurs, $idClan){
        $query=$this->db->query("select * FROM  komentar WHERE idKurs=? AND idClan=?", array($idKurs,$idClan));
        $provera=$query->result_array();
        if(count($provera)>0)
            return $provera[0]['idKom'];
        return '-1';
    }
    public function get_komentar($idKom, $myID)
    {
        $query = $this->db->query("select p.* ,l.tip
                                    FROM  `student-advisor-mysql`.komentar p
                                    left outer join `student-advisor-mysql`.podrzavanje l
                                    on p.idClan=l.idClan and l.idClan=? where
                                    p.idKom=?", array($myID,$idKom));
        return $query->row_array();
    }
    public function dodaj_podkomentar($comment, $idKom,$myID)
    {
        $this->db->query("INSERT INTO podkomentar(idKom,idClan,tekst) VALUES('$idKom','$myID','$comment')");
    }


    public function get_Komentar_clan($id,$myID)
    {
        $query = $this->db->query("select p.*, k.*, l.tip
                                    FROM  komentar p
                                    inner join kurs k 
                                    on p.idKurs = k.idkurs and p.idClan=?
                                    left outer join podrzavanje l
                                    on p.idKom=l.idKom and l.idClan=?", array($id,$myID));
        return $query->result_array();
    }
    public function get_Komentar_kurs($id, $myID)
    {
        $query = $this->db->query("select p.*, k.*, l.tip
                                    FROM  komentar p
                                    inner join clan k 
                                    on p.idClan = k.idClan and p.idKurs=?
                                    left outer join podrzavanje l
                                    on p.idKom=l.idKom and l.idClan=?", array($id,$myID));

        return $query->result_array();
    }

    public function get_komentar_predavac($idPred, $myID)
    {
        $query = $this->db->query("SELECT p.*, k.ime, c.slika, l.tip
                        FROM `student-advisor-mysql`.komentar p 
                        inner join `student-advisor-mysql`.kurs k 
                        on p.idKurs = k.idkurs 
                        inner join `student-advisor-mysql`.predaje pp 
                        on p.idKurs = pp.idKurs and pp.idPred=?
                        inner join `student-advisor-mysql`.clan c
                        on c.idClan=p.idClan
                        left outer join `student-advisor-mysql`.podrzavanje l 
                        on p.idKom=l.idKom and l.idClan=?", array($idPred,$myID));
        return $query->result_array();
    }
    public function get_pretraga_clan($id ="")
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT * FROM clan ORDER BY ime, prezime");
            return $query->result_array();
        }
        $query = $this->db->query("SELECT * FROM clan where CONCAT(ime,' ',prezime) LIKE '%".$id."%' ORDER BY ime, prezime");
        return $query->result_array();
    }
    public function get_pretraga_kurs($id ="")
    {
        if ($id === FALSE)
        {
            $query = $this->db->query("SELECT * FROM kurs ORDER BY ime" );
            return $query->result_array();
        }
        $query = $this->db->query("SELECT * FROM kurs where ime LIKE '%".$id."%' ORDER BY ime" );
        return $query->result_array();
    }
    public function get_pretraga_predavac($id ="")
    {
        if ($id =="")
        {
            $query = $this->db->query("SELECT * FROM predavac ORDER BY ime, prezime");
            return $query->result_array();
        }
        $query = $this->db->query("SELECT * FROM predavac where CONCAT(ime,' ',prezime) LIKE '%".$id."%' ORDER BY ime, prezime");
        return $query->result_array();
    }
    //ISIVESA_BEGIN
    public function put_novi_predavac($ime,$prezime,$email,$katedra,$godinaZaposlenja,$opis,$zvanje,$slika)
    {
        $this->db->query("INSERT INTO predavac(ime,prezime,email,katedra,godinaZaposlenja,opis,zvanje,slika) 
        VALUES('$ime','$prezime','$email','$katedra','$godinaZaposlenja','$opis','$zvanje','$slika')");


       
        $id = $this->db->query("SELECT MAX(idPred) FROM predavac");
        return $id;
    }

    public function put_novi_kurs($ime,$opis,$slika)
    {
        $this->db->query("INSERT INTO kurs(ime,opis,slika) VALUES ('$ime','$opis','$slika')");
    }

    public function put_predaje_na($idKurs,$idPred)//,$datumPoc)
    {
        $this->db->query("INSERT INTO predaje(idKurs,idPred,datumPoc) VALUES ('$idKurs','$idPred')");//,'$datumPoc')");
    }
    public function svi_kursevi()
    {
        $query=$this->db->query("SELECT * FROM kurs");
        return $query->result_array();
    }

    //ISIVESA_END

    //tamara
    public function put_comment($idClan , $idKurs , $comment, $anonim="false")
    {
        if ($anonim=='false')
            $query = $this->db->query("INSERT INTO komentar(idClan,idKurs,tekst,anonimno) VALUES('$idClan','$idKurs','$comment',0)");
        else
            $query = $this->db->query("INSERT INTO komentar(idClan,idKurs,tekst,anonimno) VALUES('$idClan','$idKurs','$comment',1)");
    }
	
	
	
	//ISIVESA_BEGIN
	  public function edit_predavac($ime,$prezime,$email,$katedra,$godinaZaposlenja,$opis,$zvanje,$slika, $idPred)
    {
        $this->db->query("UPDATE predavac SET 
                          ime='$ime' , prezime='$prezime' 
                          ,email='$email' , katedra='$katedra' 
                          , godinaZaposlenja='$godinaZaposlenja' , opis='$opis' 
                          , zvanje='$zvanje' , slika='$slika' WHERE idPred='$idPred'");

    }

    public function edit_kurs($ime,$opis,$slika,$idkurs)
    {
        $this->db->query("UPDATE kurs SET 
                          ime='$ime', opis='$opis' 
                          , slika='$slika' 
                           WHERE idkurs='$idkurs'");

    }
    public function get_Poruke($id = FALSE, $idSaKim = FALSE)
    {
        if ($id === FALSE || $idSaKim === FALSE)
        {
            $query = $this->db->get('poruka');
            return $query->result_array()[0];
        }
        $query= $this->db->query("SELECT p.* FROM `student-advisor-mysql`.poruka p
                           WHERE ((p.idPosiljalac='$id') AND (p.idPrimalac='$idSaKim'))
                           OR 
                           ((p.idPosiljalac='$idSaKim') AND (p.idPrimalac='$id'))
                           
                           ORDER BY p.idPor ASC");

        $this->db->query("UPDATE poruka SET procitana='d'
					WHERE idPrimalac=? AND idPosiljalac=? AND procitana='n'",array($id,$idSaKim));
        return $query->result_array();
    }
    public function get_Poslednje_Poruke($id = FALSE) //mozda radi
    {
        if ($id === FALSE) {
            return null;
        }//INNER JOIN `student-advisor-mysql`.clan c on c.idClan=idPosiljalac OR c.idClan=idPrimalac
        $query = $this->db->query("SELECT * FROM `student-advisor-mysql`.poruka 
                                    INNER JOIN `student-advisor-mysql`.clan c on (c.idClan=idPosiljalac and c.idClan!='$id') OR (c.idClan=idPrimalac and c.idClan!='$id')
                                    WHERE idPor IN 
                                    (
                                        SELECT MAX(p.idPor) FROM `student-advisor-mysql`.poruka p
                                        WHERE ((p.idPosiljalac='$id') AND
                                        NOT EXISTS (	SELECT k.idPor
                                                        FROM `student-advisor-mysql`.poruka k
                                                        WHERE k.idPrimalac=p.idPosiljalac AND k.idPosiljalac=p.idPrimalac
                                                        AND k.idPor>p.idPor
                                                    ))
                                        
                                        OR ((p.idPrimalac='$id') AND 
                                                NOT EXISTS 
                                                    ( SELECT k.idPor
                                                        FROM `student-advisor-mysql`.poruka k
                                                        WHERE k.idPosiljalac=p.idPrimalac AND k.idPrimalac=p.idPosiljalac
                                                        AND k.idPor>p.idPor
                                                    )
                                            )
                                        GROUP BY idPosiljalac,idPrimalac                        
                                    )
                                ORDER BY idPor DESC
                                
                       "
        );
        return $query->result_array();
    }
    public function get_clan_from_username($id)
    {
        $query = $this->db->get_where('clan', array('username' => $id));
        return $query->row_array();
    }
    public function put_message($id,$idSaKim,$tekst)
    {
        $query = $this->db->query("INSERT INTO poruka(idPosiljalac,idPrimalac,tekst) values('$id','$idSaKim','$tekst')");
    }


    //ISIVESA_END
}