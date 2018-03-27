class Gui {
    private Game : Game;
    private Repository : GameRepository;

    public constructor() {
        this.Game = new Game();
    }

    public display() : void {
        var html = '';
        html += '<tr>';
        html += '<th>Joueurs</th>';
        for (let playerIdx = 0; playerIdx < this.Game.PlayerList.length; playerIdx++) {
            const player = this.Game.PlayerList[playerIdx];
            html += this.buildPlayerStats(player, playerIdx)
        }
        html += '</tr>';
    
        html += '<tr>';
        html += '<th>Nouveau tour</th>';
        for (let playerIdx = 0; playerIdx < this.Game.PlayerList.length; playerIdx++) {
            const player = this.Game.PlayerList[playerIdx];
            html += this.buildPlayerForm(player, playerIdx)
        }
        html += '</tr>';
        
        for (let turnIdx = 0; turnIdx < this.Game.PlayerList[0].Turns.length; turnIdx++) {
            html += '<tr>';
            html += this.buildTitles(turnIdx) 
            for (let playerIdx = 0; playerIdx < this.Game.PlayerList.length; playerIdx++) {
                const player = this.Game.PlayerList[playerIdx];
                html += this.buildPlayerTurn(player, turnIdx)
            }
            html += '</tr>';
        }
        let tblPlayers: HTMLElement | null = document.getElementById("tblPlayers");
        if (tblPlayers !== null) {
            tblPlayers.innerHTML = html;
        }
    }
    
    protected buildTitles(turnIdx : number) : string {
        if (turnIdx === 0) {
            return '<th>Tour courrant</th>';
        } else {
            return '<th>il y a '+turnIdx+' tour'+(turnIdx>=2?'s':'')+'</th>';
        }
    }
    
    protected buildPlayerStats(player : Player, playerIdx : number) : string {
        const currentTaux : number = this.Game.calcCurrentTaux(player);
        let html = '<th>';
        html += ''+player.Name+'<br />';
        html += 'Taux courant: '+Math.round(100 * currentTaux)/100 +'  '+this.smile(player, currentTaux)+'<br />';
        html += 'Taux optimum: <input type="number" id="optimumRate_'+playerIdx+'" class="input-optimumRate" value="'+player.OptimumRate+'" required="required" min="0" max="50" step="1" /><br />';
        html += 'Taux max:     <input type="number" id="maxRate_'+playerIdx+'"     class="input-maxRate"     value="'+player.MaxRate+'"     required="required" min="0" max="50" step="1" /><br />';
        html += '</th>';
        return html;
    }
    
    protected buildPlayerForm(player : Player, playerIdx : number) : string  {
        let html = '<td>';
        html += 'Bouffe:  <input type="number" id="food_'+playerIdx+'"  class="input-food"  value="0" required="required" min="0" max="50" step="1" /><br />';
        html += 'Boisson: <input type="number" id="drink_'+playerIdx+'" class="input-drink" value="0" required="required" min="0" max="50" step="1" /><br />';
        html += '</td>';
        return html;
    }
    
    protected buildPlayerTurn(player : Player, turnIdx : number) : string  {
        const turn = player.Turns[turnIdx];
        let html = '<td>';
        html += 'Bouffe:'+turn.Food+'<br />';
        html += 'Boisson:'+turn.Drink+'<br />';
        html += 'Taux:'+this.Game.calcTaux(turn.Drink, turnIdx, this.Game.hasFoodAtTurn(player.Turns, turnIdx));
        html += '</td>';
        return html;
    }
    
    protected smile(player : Player, currentTaux : number) : string  {
      if (currentTaux < player.OptimumRate) {
          return ':-)';
      } else if (currentTaux < player.MaxRate) {
          return ':-|';
      } else {
          return ':-(';
      }
    }

    public saveStats() : void {
        this.Game.saveStats();
        this.display();
        this.Repository.saveGame(this.Game);
    }

    public saveTurn() : void {
        this.Game.saveTurn();
        this.display();
        this.Repository.saveGame(this.Game);
    }

    public addPlayer() : void {
        let playerName : string | null = window.prompt("Nom du joueur");
        if (playerName != null && playerName != '') {
            this.Game.addPlayer(playerName);
            this.display();
        }
        this.Repository.saveGame(this.Game);
    }
}
