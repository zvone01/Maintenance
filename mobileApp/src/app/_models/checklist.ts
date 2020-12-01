export class Checklist {
    ID: number;
    Template_ID: number;
    Machine_ID: number;
    Item_ID: number;
    Date_Time: Date;
    User_ID: number;
    Checked: boolean;
    Value: number;
    Note: string;
    Failure_ID: number;

    constructor() {
        this.ID = 0;
        this.Template_ID = 0;
        this.Machine_ID = 0;
        this.Item_ID = 0;
        this.Date_Time = new Date();
        this.User_ID = 0;
        this.Checked = false;
        this.Value = 0;
        this.Note = '';
        this.Failure_ID = 0;
    }

}