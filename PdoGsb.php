<?php
namespace App\MyApp;
use PDO;
use Illuminate\Support\Facades\Config;
class PdoGsb{
        private static $serveur;
        private static $bdd;
        private static $user;
        private static $mdp;
        private  $monPdo;
	
/**
 * crée l'instance de PDO qui sera sollicitée
 * pour toutes les méthodes de la classe
 */				
	public function __construct(){
        
        self::$serveur='mysql:host=' . Config::get('database.connections.mysql.host');
        self::$bdd='dbname=' . Config::get('database.connections.mysql.database');
        self::$user=Config::get('database.connections.mysql.username') ;
        self::$mdp=Config::get('database.connections.mysql.password');	  
        $this->monPdo = new PDO(self::$serveur.';'.self::$bdd, self::$user, self::$mdp); 
  		$this->monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		$this->monPdo =null;
	}
	

/**
 * Retourne les informations d'un visiteur
 
* @param $login 
 * @param $mdp
 * @return l'id, le nom et le prénom sous la forme d'un tableau associatif
 */
public function getInfosVisiteur($login, $mdp){
    $req = "SELECT visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom FROM visiteur 
    WHERE visiteur.login = :login AND visiteur.mdp = :mdp";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':login', $login);
    $stmt->bindParam(':mdp', $mdp);
    $stmt->execute();
    $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
    return $ligne;
}



/**
 * Retourne sous forme d'un tableau associatif toutes les lignes de frais au forfait
 * concernées par les deux arguments
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return l'id, le libelle et la quantité sous la forme d'un tableau associatif 
*/
	public function getLesFraisForfait($idVisiteur, $mois){
    $req = "SELECT fraisforfait.id AS idfrais, fraisforfait.libelle AS libelle, 
            lignefraisforfait.quantite AS quantite 
            FROM lignefraisforfait
            INNER JOIN fraisforfait ON fraisforfait.id = lignefraisforfait.idfraisforfait
            WHERE lignefraisforfait.idvisiteur = :idVisiteur AND lignefraisforfait.mois = :mois
            ORDER BY lignefraisforfait.idfraisforfait";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
    $lesLignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $lesLignes;
}
/**
 * Retourne tous les id de la table FraisForfait
 
 * @return un tableau associatif 
*/
	public function getLesIdFrais(){
    $req = "SELECT fraisforfait.id AS idfrais FROM fraisforfait ORDER BY fraisforfait.id";
    $stmt = $this->monPdo->prepare($req);
    $stmt->execute();
    $lesLignes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $lesLignes;
}
/**
 * Met à jour la table ligneFraisForfait
 
 * Met à jour la table ligneFraisForfait pour un visiteur et
 * un mois donné en enregistrant les nouveaux montants
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @param $lesFrais tableau associatif de clé idFrais et de valeur la quantité pour ce frais
 * @return un tableau associatif 
*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
    $lesCles = array_keys($lesFrais);
    foreach($lesCles as $unIdFrais){
        $qte = $lesFrais[$unIdFrais];
        $req = "UPDATE lignefraisforfait 
                SET quantite = :qte 
                WHERE idvisiteur = :idVisiteur 
                AND mois = :mois 
                AND idfraisforfait = :unIdFrais";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':qte', $qte);
        $stmt->bindParam(':idVisiteur', $idVisiteur);
        $stmt->bindParam(':mois', $mois);
        $stmt->bindParam(':unIdFrais', $unIdFrais);
        $stmt->execute();
    }
}

/**
 * Teste si un visiteur possède une fiche de frais pour le mois passé en argument
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return vrai ou faux 
*/	
	public function estPremierFraisMois($idVisiteur, $mois)
{
    $ok = false;
    $req = "SELECT COUNT(*) AS nblignesfrais FROM fichefrais 
            WHERE fichefrais.mois = :mois AND fichefrais.idvisiteur = :idVisiteur";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':mois', $mois);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->execute();
    $laLigne = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($laLigne['nblignesfrais'] == 0) {
        $ok = true;
    }
    return $ok;
}
/**
 * Retourne le dernier mois en cours d'un visiteur
 
 * @param $idVisiteur 
 * @return le mois sous la forme aaaamm
*/	
	public function dernierMoisSaisi($idVisiteur){
    $req = "SELECT MAX(mois) AS dernierMois FROM fichefrais WHERE fichefrais.idvisiteur = :idVisiteur";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->execute();
    $laLigne = $stmt->fetch(PDO::FETCH_ASSOC);
    $dernierMois = $laLigne['dernierMois'];
    return $dernierMois;
}
	
/**
 * Crée une nouvelle fiche de frais et les lignes de frais au forfait pour un visiteur et un mois donnés
 
 * récupère le dernier mois en cours de traitement, met à 'CL' son champs idEtat, crée une nouvelle fiche de frais
 * avec un idEtat à 'CR' et crée les lignes de frais forfait de quantités nulles 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
*/
	public function creeNouvellesLignesFrais($idVisiteur, $mois){
    $dernierMois = $this->dernierMoisSaisi($idVisiteur);
    $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
    if($laDerniereFiche['idEtat'] == 'CR'){
        $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
    }
    
    $req = "INSERT INTO fichefrais(idvisiteur, mois, nbJustificatifs, montantValide, dateModif, idEtat) 
            VALUES(:idVisiteur, :mois, 0, 0, NOW(), 'CR')";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
    
    $lesIdFrais = $this->getLesIdFrais();
    foreach($lesIdFrais as $uneLigneIdFrais){
        $unIdFrais = $uneLigneIdFrais['idfrais'];
        $req = "INSERT INTO lignefraisforfait(idvisiteur, mois, idFraisForfait, quantite) 
                VALUES(:idVisiteur, :mois, :unIdFrais, 0)";
        $stmt = $this->monPdo->prepare($req);
        $stmt->bindParam(':idVisiteur', $idVisiteur);
        $stmt->bindParam(':mois', $mois);
        $stmt->bindParam(':unIdFrais', $unIdFrais);
        $stmt->execute();
    }
}


/**
 * Retourne les mois pour lesquel un visiteur a une fiche de frais
 
 * @param $idVisiteur 
 * @return un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant 
*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select fichefrais.mois as mois from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' 
		order by fichefrais.mois desc ";
		$res = $this->monPdo->query($req);
		$lesMois =array();
		$laLigne = $res->fetch();
		while($laLigne != null)	{
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$mois"]=array(
		     "mois"=>"$mois",
		    "numAnnee"  => "$numAnnee",
			"numMois"  => "$numMois"
             );
			$laLigne = $res->fetch(); 		
		}
		return $lesMois;
	}
/**
 * Retourne les informations d'une fiche de frais d'un visiteur pour un mois donné
 
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 * @return un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
*/	
	public function getLesInfosFicheFrais($idVisiteur, $mois){
    $req = "SELECT fichefrais.idEtat AS idEtat, fichefrais.dateModif AS dateModif, fichefrais.nbJustificatifs AS nbJustificatifs, 
            fichefrais.montantValide AS montantValide, etat.libelle AS libEtat
            FROM fichefrais
            INNER JOIN etat ON fichefrais.idEtat = etat.id
            WHERE fichefrais.idvisiteur = :idVisiteur AND fichefrais.mois = :mois";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
    $laLigne = $stmt->fetch(PDO::FETCH_ASSOC);
    return $laLigne;
}
/**
 * Modifie l'état et la date de modification d'une fiche de frais
 
 * Modifie le champ idEtat et met la date de modif à aujourd'hui
 * @param $idVisiteur 
 * @param $mois sous la forme aaaamm
 */
 
 public function majEtatFicheFrais($idVisiteur, $mois, $etat){
    $req = "UPDATE fichefrais 
            SET idEtat = :etat, dateModif = NOW() 
            WHERE idvisiteur = :idVisiteur AND mois = :mois";
    $stmt = $this->monPdo->prepare($req);
    $stmt->bindParam(':etat', $etat);
    $stmt->bindParam(':idVisiteur', $idVisiteur);
    $stmt->bindParam(':mois', $mois);
    $stmt->execute();
}

	public function Listepersonne(){
		$req = "SELECT * FROM visiteur";
		$stmt = $this->monPdo->query($req);
		$laLigne = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $laLigne;
	}

	public function selectionneruser($id){
		$req = "SELECT * FROM visiteur WHERE id = :id";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
		$laLigne = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $laLigne;
	}

	public function supprimerUser($id){
		$req = "DELETE FROM visiteur WHERE id = :id";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	public function ajouter($id, $nom, $prenom, $login, $mdp, $adresse, $cp, $ville, $date){
		$req = "INSERT INTO visiteur (id, nom, prenom, login, mdp, adresse, cp, ville, dateEmbauche)
				VALUES (:id, :nom, :prenom, :login, :mdp, :adresse, :cp, :ville, :date)";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':id', $id);
		$stmt->bindParam(':nom', $nom);
		$stmt->bindParam(':prenom', $prenom);
		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':mdp', $mdp);
		$stmt->bindParam(':adresse', $adresse);
		$stmt->bindParam(':cp', $cp);
		$stmt->bindParam(':ville', $ville);
		$stmt->bindParam(':date', $date);
		$stmt->execute();
	}

	public function modifierUser($id, $nom, $prenom, $login, $adresse, $cp, $ville, $date, $mdp){
		$req = "UPDATE visiteur 
				SET nom = :nom, prenom = :prenom, login = :login, adresse = :adresse, cp = :cp, ville = :ville, dateEmbauche = :date, mdp = :mdp
				WHERE id = :id";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':nom', $nom);
		$stmt->bindParam(':prenom', $prenom);
		$stmt->bindParam(':login', $login);
		$stmt->bindParam(':adresse', $adresse);
		$stmt->bindParam(':cp', $cp);
		$stmt->bindParam(':ville', $ville);
		$stmt->bindParam(':date', $date);
		$stmt->bindParam(':mdp', $mdp);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	}

	public function testSuppression($id){
		$req = "SELECT * FROM visiteur
				INNER JOIN fichefrais ON visiteur.id = fichefrais.idVisiteur
				WHERE visiteur.id = :id";
		$stmt = $this->monPdo->prepare($req);
		$stmt->bindParam(':id', $id);
		$stmt->execute();
	
		// Vérifie s'il y a des résultats (l'utilisateur est associé à des fiches de frais)
		return $stmt->rowCount() > 0;
	}

	





}
