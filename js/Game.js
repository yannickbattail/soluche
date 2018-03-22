var Game = /** @class */ (function () {
    function Game() {
        this.PlayerList = [
            new Player("yaya"),
            new Player("yoyo"),
        ];
    }
    Game.prototype.addPlayer = function (playerName) {
        if (playerName === null || playerName == '') {
            return;
        }
        this.PlayerList.push(new Player(playerName, 5, 7));
    };
    Game.prototype.saveTurn = function () {
        for (var playerIdx = 0; playerIdx < this.PlayerList.length; playerIdx++) {
            this.PlayerList[playerIdx].Turns.unshift(new Turn(parseInt(document.getElementById("food_" + playerIdx).value), parseInt(document.getElementById("drink_" + playerIdx).value)));
        }
    };
    Game.prototype.saveStats = function () {
        for (var playerIdx = 0; playerIdx < this.PlayerList.length; playerIdx++) {
            this.PlayerList[playerIdx].OptimumRate = parseInt(document.getElementById("optimumRate_" + playerIdx).value);
            this.PlayerList[playerIdx].MaxRate = parseInt(document.getElementById("maxRate_" + playerIdx).value);
        }
    };
    Game.prototype.calcCurrentTaux = function (player) {
        var taux = 0;
        for (var turnIdx = 0; turnIdx < player.Turns.length; turnIdx++) {
            var hasFood = this.hasFoodAtTurn(player.Turns, turnIdx);
            var drink = player.Turns[turnIdx].Drink;
            taux += this.calcTaux(drink, turnIdx, hasFood);
        }
        return taux;
    };
    Game.prototype.calcTaux = function (drink, turn, hasFood) {
        var DIVISER = 8;
        var coef = 0;
        if (hasFood) {
            if (turn <= 4) {
                coef = 2 * turn;
            }
            else if (turn < 12) {
                coef = (-1 * turn + 12);
            }
        }
        else {
            if (turn <= 4) {
                coef = 3 * turn;
            }
            else if (turn < 16) {
                coef = (-1 * turn + 16);
            }
        }
        return drink * coef / DIVISER;
    };
    Game.prototype.hasFood = function (turns) {
        for (var turnIdx = 0; turnIdx < turns.length; turnIdx++) {
            var food = turns[turnIdx].Food;
            if (food && (food >= turnIdx)) {
                return true;
            }
        }
        return false;
    };
    Game.prototype.hasFoodAtTurn = function (turns, atTurn) {
        return this.hasFood(turns.slice(atTurn));
    };
    return Game;
}());
//# sourceMappingURL=Game.js.map