class Player {
    public name : string;
    
    protected _optimumRate : number;
    
    get optimumRate(): number {
        return this._optimumRate;
    }

    set optimumRate(newOptimumRate: number) {
        if (newOptimumRate < 1) {
            this._optimumRate = 1;
            console.warn("optimumRate < 1 : value forced to 1");
        } else if (newOptimumRate >= this._maxRate) {
            this._optimumRate = this._maxRate - 1;
            console.warn("optimumRate >= maxRate : value forced to maxRate - 1");
        } else {
            this._optimumRate = newOptimumRate;
        }
    }

    protected _maxRate : number;

    get maxRate(): number {
        return this._maxRate;
    }

    set maxRate(newMaxRate: number) {
        if (newMaxRate < 2) {
            this._maxRate = 2;
            console.warn("maxRate < 2 : value forced to 2");
        } else if (newMaxRate <= this._optimumRate) {
            this._maxRate = this._maxRate - 1;
            console.warn("maxRate <= optimumRate : value forced to optimumRate + 1");
        } else {
            this._maxRate = newMaxRate;
        }
    }

    public turns : Turn[];
}