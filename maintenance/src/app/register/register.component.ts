import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, FormControl, FormArray, Validators } from '@angular/forms';
import { UserService } from '../_services';
import { of } from 'rxjs';
import { UserTypes } from '../_models';
import { MatSnackBar } from '@angular/material/snack-bar';
import { first } from 'rxjs/operators';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent implements OnInit {
  registerForm: FormGroup;
  userTypes: UserTypes[];

  public Name: string
  public Surname: string
  public Username: string
  public Type: string
 
  constructor(private formBuilder: FormBuilder, private userService: UserService, private _snackBar: MatSnackBar) {
  
  }


  public NameChange(str: string): void {

    if(this.Surname != undefined)
      this.Username = str + this.Surname.substring(0, 1);
   else
      this.Username = str;
  }

  public SurnameChange(str: string): void {
    
    if(this.Name != undefined)
    this.Username = this.Name + str.substring(0, 1);
   else if(str != undefined)
      this.Username = str.substring(0, 1);
   else
      this.Username = str;
   }

   onItemChange(str): void{

    console.log(str.target.value);

    if (str.target.value == "admin")
       this.registerForm.value["usertype"] = 1
       else if (str.target.value == "user") 
       this.registerForm.value["usertype"] = 2
       else if (str.target.value == "disabled") 
       this.registerForm.value["usertype"] = 3
   }
  
 

  ngOnInit() {

    this.resetForm();
    this.loadAllUserTypes();


  }

  resetForm() {
    this.registerForm = this.formBuilder.group({
      name: [null, Validators.required],
      surname: [null, Validators.required],
      username: [null],
      password: [null, Validators.required],
      email: [null],
      usertype: [null]
    });
  }

  isChecked(id)
  {
    console.log(id.target.id);
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, "Close", {
      duration: 5000,
    });
  }


  onSubmit() {
    // this.submitted = true;
    if (this.registerForm.invalid) {
      this.openSnackBar("Form error")
      return;
    }

    console.log(this.registerForm.value);
    this.userService.create(this.registerForm.value)
      .pipe(first())
      .subscribe(

        data => {
          console.log(data["message"]);
          this.openSnackBar(data["message"])
          this.resetForm();

        },
        error => {
          console.log("Error");
          this.openSnackBar("Error")

        });

  }


  private loadAllUserTypes() {
    this.userService.getAllTypes()
      .subscribe(x => {
        this.userTypes = x['usertypes'];
      });

  
  };

}
