class Player {
    public Name : string;
    
    protected _optimumRate : number;
    
    get OptimumRate(): number {
        return this._optimumRate;
    }

    set OptimumRate(newOptimumRate: number) {
        if (newOptimumRate <= 0) {
            this._optimumRate = 1;
            console.warn("optimumRate <= 0 : value forced to 1");
        } else if (newOptimumRate >= this._maxRate) {
            this._optimumRate = this._maxRate - 1;
            console.warn("optimumRate >= maxRate : value forced to maxRate - 1");
        } else {
            this._optimumRate = newOptimumRate;
        }
    }

    protected _maxRate : number;

    get MaxRate(): number {
        return this._maxRate;
    }

    set MaxRate(newMaxRate: number) {
        if (newMaxRate < 2) {
            this._maxRate = 2;
            console.warn("maxRate < 2 : value forced to 2");
        } else if (newMaxRate <= this._optimumRate) {
            this._maxRate = this._optimumRate + 1;
            console.warn("maxRate <= optimumRate : value forced to optimumRate + 1");
        } else {
            this._maxRate = newMaxRate;
        }
    }

    public Turns : Turn[] = [];

    public constructor(name : string, optimumRate : number = 1, maxRate : number = 2) {
        this.Name = name;
        this.OptimumRate = optimumRate;
        this.MaxRate = maxRate;
    }
}