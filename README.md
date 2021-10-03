Paleidimas:

git clone https://github.com/ngreed/homework.git

cd homework

composer install

php bin/phpunit

php bin/console app:shipping-parse-data-from-file input.txt

Komentarai:

Palikau nesutvarkyta .gitignore, todel prikomitinta nereikalingu failu.

Kai kurie duomenys tikroje situacijoje butu saugomi duombazeje (pvz provideriai, transakcijos) ir butu sukurti enticiai, taciau laiko taupymo sumetimais to neimplementavau. 

Kadangi siuo metu provideriai ne enticiu pavidalu, juos butu galima implementuoti su virtualiomis klasemis, nes logika visiskai nesiskiria.

Funkciju anotacijas pridejau tik tose vietose, kur jos suteikia papildomos informacijos (pvz is kokiu elementu sudarytas masyvas).

Pilnai pripazistu, kad galejau geriau padirbeti su klasiu/funkciju pavadinimais bei namespace'ais.

Nebuvau tikras del taisykliu:
 - "Third L shipment via LP should be free, but only once a calendar month". Siuo metu implementavau taip, kad siuntiniu skaiciavimas nesiresetina kas menesi, o resetinasi tik discounto applyinimas. Tai reiskia kad rezultatai butu tokie:
	2015-02-20 L LP 6.90 -
	2015-02-26 L LP 6.90 -
	2015-03-02 L LP 0 6.90

 - "All S shipments should always match the lowest S package price among the providers". Siuo metu implementavau taip, kad taisykle nesiresetina niekados (galioja visam failui). Tai reiskia, jei faile butu tukstanciai irasu per, sakykim, puse metu, ir tik pats paskutinis irasas butu pigesnes kainos, tai vis tiek ta pigesne kaina applyintu visiems failo irasams. Skamba nelabai tiketinai (nors aisku realybeje failai turbut ne tokie), taciau kol neturiu is jusu informacijos, kad reiketu implementuoti kitaip, palikau taip. 

Su testais irgi per daug negaisau. Jei noretumete kad pakeisciau taisykliu veikima, ar prideciau papildomu testu/testcase'u, let me know. 
