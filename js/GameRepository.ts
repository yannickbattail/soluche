class GameRepository {
    public saveGame(game : Game) : void {
        window.localStorage.game = game;
    }

    public loadGame() : Game {
        let game : Game;
        if (window.localStorage.game) {
            game = window.localStorage.game;
        } else {
            console.log('no game in localStorage, create a new one');
            game = new Game();
        }
        return game;
    }
}
