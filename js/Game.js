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
            var food = this.getValue("food_" + playerIdx);
            var drink = this.getValue("drink_" + playerIdx);
            this.PlayerList[playerIdx].Turns.unshift(new Turn(food !== null ? parseInt(food) : 0, drink !== null ? parseInt(drink) : 0));
        }
    };
    Game.prototype.getValue = function (id) {
        var elem = document.getElementById(id);
        if (elem && elem['value']) {
            return elem['value'];
        }
        else {
            return null;
        }
    };
    Game.prototype.saveStats = function () {
        for (var playerIdx = 0; playerIdx < this.PlayerList.length; playerIdx++) {
            var optimumRate = this.getValue("optimumRate_" + playerIdx);
            var maxRate = this.getValue("maxRate_" + playerIdx);
            this.PlayerList[playerIdx].OptimumRate = optimumRate !== null ? parseInt(optimumRate) : 0;
            this.PlayerList[playerIdx].MaxRate = maxRate !== null ? parseInt(maxRate) : 0;
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