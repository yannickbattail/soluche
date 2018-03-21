class Turn {
    protected _food : number;

    get food(): number {
        return this._food;
    }

    set food(newFood: number) {
        if (newFood < 0) {
            this._food = 0;
        } else {
            
            this._food = newFood;
        }
    }


    protected _drink : number;

    get drink(): number {
        return this._drink;
    }

    set drink(newDrink: number) {
        if (newDrink < 0) {
            this._drink = 0;
        } else {
            
            this._drink = newDrink;
        }
    }
}