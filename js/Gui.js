var Gui = /** @class */ (function () {
    function Gui() {
        this.Game = new Game();
    }
    Gui.prototype.display = function () {
        var html = '';
        html += '<tr>';
        html += '<th>Joueurs</th>';
        for (var playerIdx = 0; playerIdx < this.Game.PlayerList.length; playerIdx++) {
            var player = this.Game.PlayerList[playerIdx];
            html += this.buildPlayerStats(player, playerIdx);
        }
        html += '</tr>';
        html += '<tr>';
        html += '<th>Nouveau tour</th>';
        for (var playerIdx = 0; playerIdx < this.Game.PlayerList.length; playerIdx++) {
            var player = this.Game.PlayerList[playerIdx];
            html += this.buildPlayerForm(player, playerIdx);
        }
        html += '</tr>';
        for (var turnIdx = 0; turnIdx < this.Game.PlayerList[0].Turns.length; turnIdx++) {
            html += '<tr>';
            html += this.buildTitles(turnIdx);
            for (var playerIdx = 0; playerIdx < this.Game.PlayerList.length; playerIdx++) {
                var player = this.Game.PlayerList[playerIdx];
                html += this.buildPlayerTurn(player, turnIdx);
            }
            html += '</tr>';
        }
        var tblPlayers = document.getElementById("tblPlayers");
        if (tblPlayers !== null) {
            tblPlayers.innerHTML = html;
        }
    };
    Gui.prototype.buildTitles = function (turnIdx) {
        if (turnIdx === 0) {
            return '<th>Tour courrant</th>';
        }
        else {
            return '<th>il y a ' + turnIdx + ' tour' + (turnIdx >= 2 ? 's' : '') + '</th>';
        }
    };
    Gui.prototype.buildPlayerStats = function (player, playerIdx) {
        var currentTaux = this.Game.calcCurrentTaux(player);
        var html = '<th>';
        html += '' + player.Name + '<br />';
        html += 'Taux courant: ' + Math.round(100 * currentTaux) / 100 + '  ' + this.smile(player, currentTaux) + '<br />';
        html += 'Taux optimum: <input type="number" id="optimumRate_' + playerIdx + '" class="input-optimumRate" value="' + player.OptimumRate + '" required="required" min="0" max="50" step="1" /><br />';
        html += 'Taux max:     <input type="number" id="maxRate_' + playerIdx + '"     class="input-maxRate"     value="' + player.MaxRate + '"     required="required" min="0" max="50" step="1" /><br />';
        html += '</th>';
        return html;
    };
    Gui.prototype.buildPlayerForm = function (player, playerIdx) {
        var html = '<td>';
        html += 'Bouffe:  <input type="number" id="food_' + playerIdx + '"  class="input-food"  value="0" required="required" min="0" max="50" step="1" /><br />';
        html += 'Boisson: <input type="number" id="drink_' + playerIdx + '" class="input-drink" value="0" required="required" min="0" max="50" step="1" /><br />';
        html += '</td>';
        return html;
    };
    Gui.prototype.buildPlayerTurn = function (player, turnIdx) {
        var turn = player.Turns[turnIdx];
        var html = '<td>';
        html += 'Bouffe:' + turn.Food + '<br />';
        html += 'Boisson:' + turn.Drink + '<br />';
        html += 'Taux:' + this.Game.calcTaux(turn.Drink, turnIdx, this.Game.hasFoodAtTurn(player.Turns, turnIdx));
        html += '</td>';
        return html;
    };
    Gui.prototype.smile = function (player, currentTaux) {
        if (currentTaux < player.OptimumRate) {
            return ':-)';
        }
        else if (currentTaux < player.MaxRate) {
            return ':-|';
        }
        else {
            return ':-(';
        }
    };
    Gui.prototype.saveStats = function () {
        this.Game.saveStats();
        this.display();
    };
    Gui.prototype.saveTurn = function () {
        this.Game.saveTurn();
        this.display();
    };
    Gui.prototype.addPlayer = function () {
        var playerName = window.prompt("Nom du joueur");
        if (playerName != null && playerName != '') {
            this.Game.addPlayer(playerName);
            this.display();
        }
    };
    return Gui;
}());
//# sourceMappingURL=Gui.js.map