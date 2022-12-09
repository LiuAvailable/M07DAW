# PHP - Concurs de gossos amb POO i PDO
## DAW-MP07-UF3 - Exercici de Tècniques d'accés a dades.
La següent pràctica consisteix a crear un sistema de votacions populars pel [Concurs Internacional de Gossos d'Atura](https://ca.wikipedia.org/wiki/Concurs_Internacional_de_Gossos_d%27Atura_de_Castellar_de_n%27Hug).
Els 9 gossos concursants participaran durant 8 fases, cada una d'aquestes fases és eliminatòria i s'elimina un gos. Aquest any, però es decidirà quin és el gos eliminat mitjançant un sistema de votacions populars.

Pels visitants hi haurà tres pàgines:
+ Una pàgina pública on fer les votacions
+ Una pàgina pública de resultats (on es van mostrant els resultats de cada fase)
+ Una pàgina privada d'administració (requerirà un sistema d'inici de sessió)

La pàgina de votacions permetrà votar realitzar un sol vot a cada fase, ens sortirà un avís quan ja hàgim votat, però podrem canviar el nostre vot. Si no hi ha cap fase activa ens apareix un avís, i evidentment no podrem votar.
+ Cal afegir un GET 'data' amb el format 'AAAA.MM.DD' per poder provar el sistema en dates anteriors.
+ (Extra) No afegeixis un botó per fer la submisió.

La pàgina resultats mostrarà quin gos ha estat eliminat a cada fase un cop s'hagi tancat aquesta i els percentatges a cada votació.
+ Només es mostraran les fases superades.
+ S'eliminarà el gos que tingui menys vots, en cas d'empat s'eliminarà amb la suma de percentatges més baix a les fases anteriors. En un nou cas d'empat es farà un sorteig entre els empatats.

A la pàgina d'administració (amb sistema de login) s'hi podrà accedir amb l'usuari "admin", contrasenya "admin".
+ Dins podrem crear un nou usuari per accedir-hi.
+ Veurem la llista de gossos concursants, en podrem afegir i modificar-ne els camps (nom, imatge, amo, raça)
+ Podrem modificar les dates d'inici i tancament de cada fase. Per defecte: cada fase durarà un mes a partir del gener del 2023.
+ Podrem esborrar tots els vots d'una fase.
+ Podrem esborrar tots els vots.
+ Podrem veure els resultats parcials de la fase activa.

Cal utilitzar [programació orientada a objectes](https://aniollidon.gitbook.io/daw-m07.-desenvolupament-web-entorn-servidor/poo) i fer l'accés de dades de forma segura amb PDO

---

#FpInfor #Daw #DawMp07 #DawMp07Uf03

* Resultats d'aprenentatge 1.b 1.c 1.d 1.e
* Continguts 1.2 1.3 1.4 1.5
---

###### Autor: Aniol Lidon 2022.11.17
###### [CC BY](https://creativecommons.org/licenses/by/4.0/) ![CC BY](https://licensebuttons.net/l/by/3.0/80x15.png)