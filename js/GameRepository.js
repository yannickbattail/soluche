var GameRepository = /** @class */ (function () {
    function GameRepository() {
    }
    GameRepository.prototype.saveGame = function (game) {
        window.localStorage.game = game;
    };
    GameRepository.prototype.loadGame = function () {
        var game;
        if (window.localStorage.game) {
            game = window.localStorage.game;
        }
        else {
            console.log('no game in localStorage, create a new one');
            game = new Game();
        }
        return game;
    };
    return GameRepository;
}());
//# sourceMappingURL=GameRepository.js.map