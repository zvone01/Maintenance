export class Checklisttemplate {
    ID: number;
    Name: string;
    Frequency: number;
    Machine_ID: number;
    StartDate: string;
    EndDate: string;

    constructor()
    {
        this.ID = -1;
        this.Name = "";
        this.Frequency  = -1;
        this.Machine_ID = -1;
        this.StartDate = "";
        this.EndDate = "";
    }
}