class Turn {
    protected _food : number;

    get Food(): number {
        return this._food;
    }

    set Food(newFood: number) {
        if (newFood < 0) {
            this._food = 0;
        } else {
            
            this._food = newFood;
        }
    }


    protected _drink : number;

    get Drink(): number {
        return this._drink;
    }

    set Drink(newDrink: number) {
        if (newDrink < 0) {
            this._drink = 0;
        } else {
            
            this._drink = newDrink;
        }
    }

    public constructor(food : number, drink : number) {
        this.Food = food;
        this.Drink = drink;
    }
}