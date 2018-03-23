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
    let food  : string | null = this.getValue("food_"+playerIdx);
    let drink : string | null = this.getValue("drink_"+playerIdx);
    this.PlayerList[playerIdx].Turns.unshift(new Turn(
        food!==null?parseInt(food):0,
        drink!==null?parseInt(drink):0,
      ));
  }
}

public getValue(id : string) : string | null {
  let elem : HTMLElement | null = document.getElementById(id);
  if (elem && elem['value']) {
    return elem['value'];
  } else {
    return null;
  }
}

public saveStats() : void {
  for (let playerIdx : number = 0; playerIdx < this.PlayerList.length; playerIdx++) {
    let optimumRate  : string | null = this.getValue("optimumRate_"+playerIdx);
    let maxRate : string | null = this.getValue("maxRate_"+playerIdx);
    this.PlayerList[playerIdx].OptimumRate = optimumRate!==null?parseInt(optimumRate):0;
    this.PlayerList[playerIdx].MaxRate     = maxRate!==null?parseInt(maxRate):0;
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
