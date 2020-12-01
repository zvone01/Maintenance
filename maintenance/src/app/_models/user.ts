export class User {
    ID: number;
    Name: string;
    Surname: string;
    Username: string;
    Password: string;
    Email: string;
    TypeID: number;

    constructor()
    {
        this.ID = -1;
        this.Name = "";
        this.Surname = "";
        this.Username = "";
        this.Password = "";
        this.Email = "";
        this.TypeID = -1;
    }

}