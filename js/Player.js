var Player = /** @class */ (function () {
    function Player(name, optimumRate, maxRate) {
        if (optimumRate === void 0) { optimumRate = 1; }
        if (maxRate === void 0) { maxRate = 2; }
        this.Turns = [];
        this.Name = name;
        this.OptimumRate = optimumRate;
        this.MaxRate = maxRate;
    }
    Object.defineProperty(Player.prototype, "OptimumRate", {
        get: function () {
            return this._optimumRate;
        },
        set: function (newOptimumRate) {
            if (newOptimumRate <= 0) {
                this._optimumRate = 1;
                console.warn("optimumRate <= 0 : value forced to 1");
            }
            else if (newOptimumRate >= this._maxRate) {
                this._optimumRate = this._maxRate - 1;
                console.warn("optimumRate >= maxRate : value forced to maxRate - 1");
            }
            else {
                this._optimumRate = newOptimumRate;
            }
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(Player.prototype, "MaxRate", {
        get: function () {
            return this._maxRate;
        },
        set: function (newMaxRate) {
            if (newMaxRate < 2) {
                this._maxRate = 2;
                console.warn("maxRate < 2 : value forced to 2");
            }
            else if (newMaxRate <= this._optimumRate) {
                this._maxRate = this._optimumRate + 1;
                console.warn("maxRate <= optimumRate : value forced to optimumRate + 1");
            }
            else {
                this._maxRate = newMaxRate;
            }
        },
        enumerable: true,
        configurable: true
    });
    return Player;
}());
//# sourceMappingURL=Player.js.map