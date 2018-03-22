var Turn = /** @class */ (function () {
    function Turn(food, drink) {
        this.Food = food;
        this.Drink = drink;
    }
    Object.defineProperty(Turn.prototype, "Food", {
        get: function () {
            return this._food;
        },
        set: function (newFood) {
            if (newFood < 0) {
                this._food = 0;
            }
            else {
                this._food = newFood;
            }
        },
        enumerable: true,
        configurable: true
    });
    Object.defineProperty(Turn.prototype, "Drink", {
        get: function () {
            return this._drink;
        },
        set: function (newDrink) {
            if (newDrink < 0) {
                this._drink = 0;
            }
            else {
                this._drink = newDrink;
            }
        },
        enumerable: true,
        configurable: true
    });
    return Turn;
}());
//# sourceMappingURL=Turn.js.map