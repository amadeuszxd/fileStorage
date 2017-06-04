<?php
namespace Dframe\fileStorage;

/*
 * Klasa abstrakcyjna stylisty
 * 
 * Stylista to obiekt, ktory przetwarza obraz wedlug okreslonego schematu
 * (np. przycina, wyszarza, zmniejsza itp.)
 * 
 * Kazdy stylista powinien miec metode stylize($image), ktora pobiera oryginal
 * w formie ciagu bajtow i zwraca go po przetworzeniu, tez w formie ciagu bajtow
 * 
 * Podklasy stylistow powinny znajdowac sie w folderze stylists
 */
abstract class stylist {
	
	/**
	 * Pobiera oryginal i zwraca w przetworzonej formie. Dane wejsciowe to reource obrazu dla biblioteki
	 * PHP GD, a wyjscie to resource z przetworzonym obrazem
	 * @param layer
	 * @param array
	 * @return layer
	 */
	abstract public function stylize($layer, $stylistParam);
	
	/**
	 * Zwraca unikalna nazwe stylisty, takze w zaleznosci od parametrow
	 * @param array
	 * @return string
	 */
	abstract public function identify($stylistParam);
	  
	  
 
}