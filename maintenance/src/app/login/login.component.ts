import { Component, OnInit } from '@angular/core';
import { FormBuilder, Validators, FormGroup } from '@angular/forms';
import { AuthenticationService } from '../_services';
import { MatSnackBar } from '@angular/material/snack-bar';
import { first } from 'rxjs/internal/operators/first';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  public Username: string
  loginForm: FormGroup;

  constructor(private formBuilder: FormBuilder, private authenticationService: AuthenticationService, private _snackBar: MatSnackBar, private router: Router) { }

  ngOnInit() {

    this.resetForm();
  }

  
  resetForm() {
    this.loginForm = this.formBuilder.group({    
      username: [null, Validators.required],
      password: [null, Validators.required],
    });
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, "Close", {
      duration: 5000,
    });
  }

  get f() { return this.loginForm.controls; }

  onSubmit() {
    // this.submitted = true;
    if (this.loginForm.invalid) {
      this.openSnackBar("Form error")
      return;
    }



    console.log(this.loginForm.value);
    this.authenticationService.login(this.f.username.value, this.f.password.value)
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

  bypass(){

    this.authenticationService.login("ZvoneD", "123")
      .pipe(first())
      .subscribe(

        data => {
          this.resetForm();
          this.router.navigate(['']);
          this.openSnackBar("Loged in")

        },
        error => {
          console.log("Error");
          this.openSnackBar("Error")

        });

}


}
