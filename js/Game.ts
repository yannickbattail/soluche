class Game {
public PlayerList : Array<Player> = [
    new Player("yaya"),
    new Player("yoyo"),
];

public addPlayer(playerName : string) : void {
  if (playerName === null || playerName == '') {
      return ;
  }
  this.PlayerList.push(new Player(playerName, 5, 7));
}

public saveTurn() : void {
  for (let playerIdx : number = 0; playerIdx < this.PlayerList.length; playerIdx++) {
    this.PlayerList[playerIdx].Turns.unshift(new Turn(
        parseInt(document.getElementById("food_"+playerIdx)!.value),
        parseInt(document.getElementById("drink_"+playerIdx)!.value),
      ));
  }
}

public saveStats() : void {
  for (let playerIdx : number = 0; playerIdx < this.PlayerList.length; playerIdx++) {
    this.PlayerList[playerIdx].OptimumRate = parseInt(document.getElementById("optimumRate_"+playerIdx)!.value);
    this.PlayerList[playerIdx].MaxRate     = parseInt(document.getElementById("maxRate_"+playerIdx)!.value);
  }
}

public calcCurrentTaux(player : Player) : number {
    let taux : number = 0;
    for (let turnIdx : number = 0; turnIdx < player.Turns.length; turnIdx++) {
     var hasFood = this.hasFoodAtTurn(player.Turns, turnIdx);
     var drink = player.Turns[turnIdx].Drink;
     taux += this.calcTaux(drink, turnIdx, hasFood);
    }
    return taux;
  }
  
  public calcTaux(drink : number, turn : number, hasFood : boolean) : number {
    const DIVISER : number = 8;
    let coef : number = 0;
    if (hasFood) {
      if (turn <= 4) {
          coef = 2 * turn;
      } else if (turn < 12) {
          coef = (-1 * turn + 12);
      }
    } else {
      if (turn <= 4) {
          coef = 3 * turn;
      } else if (turn < 16) {
          coef = (-1 * turn + 16);
      }
    }
    return drink * coef / DIVISER;
  }
  
  protected hasFood(turns : Array<Turn>) : boolean {
    for (let turnIdx : number = 0; turnIdx < turns.length; turnIdx++) {
      let food : number = turns[turnIdx].Food;
      if (food && (food >= turnIdx)) {
        return true;
      }
    }
    return false;
  }

  public hasFoodAtTurn(turns : Array<Turn>, atTurn : number) : boolean {
    return this.hasFood(turns.slice(atTurn));
  }
  
}
