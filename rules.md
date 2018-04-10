# Les menstruations

(les règles)

## Les concepts

Idée: l'effet de l'alcool est retardé Et où tu ne connais pas trop les quantités d'alcool Ni combien tu tiens. Tu prends un verre et son effet augmente rapidement jusqu’à 1h apres où il atteint sont effet max et ensuite il décrois doucement les heures qui suivent. Note si tu n'a pas mangé avant c'est bien pire

La réussite de tes actions dépend des effets de l'alcool. Plus tu as bu plus tu réussiras, jusqu’à une limite optimum, après cette limite tes actions auront des comportement plutôt aléatoire. et au delà d'une limite max ca sera la PLS (ca se traduit par le fait que le joueur doive passer ses tours jusqu'a ce que sont taux redescende en dessous du max)

### Comment récupérer le taux du joueur ?

Manger : pour chaque repas on a la durée pendant laquelle on est rassasié. les durées ne s'ajoutent pas.
Ex : un repas 16T puis un T plus tard un gouté de 4T vous tiendras rassasié juste 15T (1T viens de se passer).
Si le verre est bu pendant qu'on est dans une période rassasié on suis la courbe verte et quand on est à jeun la courbe rouge.

### un dé7

- je sais plus si je t'ai dit? soluche papier se joue avec un dé7
- lol! un dé6litre ?
- oui, mais non. Un dé7 c'est un dé à avec les faces numérotées de 0 à 6. Et si tu as pas de dé7
- tu utilise un d6 auquel tu rajoute une face?
- Non, enfin si! Donc si le dé est cassé ou en dehors du plateau ca fait 0
- Mouais,c'est pas très équiprobable
- oui mais c'est les règles!
- remarque sanglante. cinglante*

## Le début de partie

### Création des persos

Chaque joueur doit passer le test du crie fort. Une fois fini il doit avoir 2 notes sur 14 en sesque et en boisson.

Son taux optimum d'alcool sera égale à note au crieFort en boisson divisée par 2 plus .

    ex:  note au crieFort en boisson : 4
    taux optimum = 4 / 2 + 5 = 8

Son taux max d'alcool sera eagle à son taux optimum d'alcool multiplié par 1,5

    ex:  taux optimum : 8
    taux max = 8 x 1,5 = 12

La crédibilitruc sera la note au crieFort en sesque divisée par 3 plus 4 plus de résultat d'un lancé d'un dé 7

    note au crieFort en sesque : 12
    dé6 : 5
    credibilitruc = 12 / 3 + 4 + 5 = 13

#### note sur les arrondis des nombres à virgule

Si les calcules donnent des nombres non entiers, il faut arrondir ces nombres de gré ou de force.

Pour savoir si l'on doit arrondir à l'entier supérieur au inférieur, on joue ça au lancé de chat.

La méthode est simple: on prend un chat, on le lance, puis on applique l'algorithme suivant:

```lua
if (face sur laquelle retombe le chat = pattes) then
    arrondi supérieur
else
    arrondi supérieur
end
```

### préparation

Choisir le type de partie: apéro 12 tours, soiree 24 tours, congres 42 tours. (sachant que 1 tours correspond à peu pres à 1/4 d'heure réelle)

Au debut de la partie distribuer des items pour un nombre = au nombre de tours divisé pas 2. Ex : partie de 3h = 12 tours donc 6 cartes

## Actions possibles

### Chanter

+10@ ou +0@, -1paillardier

### Partager des valeurs

+X@, X= nombre personnes * la valeur@ de la carte, (nombre de personnes en comptant soi même)

Ajouter aux participants et soi même, les points de nourriture et boisson.

### Pinsser

+2@ pour moi, +1@ pour lui et +1 en boisson pour lui

### concours de sec

À tour de rôle les 2 joueurs se donnent des sec jusqu'à ce qu'un des 2 abandonne.

Attention à la PLS après coup.

### ‎faire un VT

-4@: -4 en boisson

### PLS volontaire

passe son tour

Le tour suivant, on lance un d6, si > 4 il se réveil, sinon la PLS continue.

Le tour suivant, on lance un d6, si > 3 il se réveil, sinon la PLS continue.

Le tour suivant, on lance un d6, si > 2 il se réveil, sinon la PLS continue.

Le tour suivant il se réveille.

### PLS involontaire (taux de boisson au dessus du max)

Passe son tour jusqu'à que son taux de boisson passe en dessous du max

### Essayer de chopper (1 tour)

Le joueur qui essaye de chopper choisi une cible parmi les PNJ du lieu (tas de cartes) ou parmi les personnages s'y trouvant aussi.

Ensuite le joueur doit sortir une puch line et les autres joueurs vote la qualité de celle-ci.

- pouce en haut : ça passe nickel comme papa dans mamie
- pouce horizontale : bourré ça peut passer
- pouce vers le bas : même pas en rêve

Et on fait les comptes.

On ne sais si ça a réussi qu'au début du tour suivant.

Mais comment on le sais?

On calcule la différence de crédibilitruc entre les 2 persos en valeur absolue

au quel on soustrait les bonus/malus de choppe puis on soustrait au résultat un dé7.

Si la valeur finale est négative ou égale à zéro ca va baiser. Sinon ... couilles bleues (rien de se passe)

Ex:

    crédibilitruc du perso : 6
    crédibilitruc du perso cible : 8
    bonus/malus de choppe du perso : 1 - 1 = 0
    lancé dé 7 : 3
    différence de crédibilitruc |6 - 8| = |-2| = 2
    2 - 0 - 3 = -3
    ==> la tente va bouger ce soir

### Chopper (3 tours)

