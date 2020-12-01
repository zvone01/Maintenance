import { Component, OnInit } from '@angular/core';
import { MachineService } from '../_services';
import { first } from 'rxjs/operators';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatFormFieldModule } from '@angular/material/form-field';

@Component({
  selector: 'app-machine-edit',
  templateUrl: './machine-edit.component.html',
  styleUrls: ['./machine-edit.component.css']
})
export class MachineEditComponent implements OnInit {

  submitted = false;
  createMachineForm: FormGroup;

  constructor(private machineService: MachineService,
    private formBuilder: FormBuilder, private _snackBar: MatSnackBar) { }

  ngOnInit() {
    this.resetForm();
  }
  
  resetForm() {
    this.createMachineForm = this.formBuilder.group({
      name: [null, Validators.required],
      description: [null]
    });
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, "Close", {
      duration: 5000,
    });
  }
  
  onSubmit() {
    // this.submitted = true;
    if (this.createMachineForm.invalid) {
      console.log("Name empty");
      this.openSnackBar("Name empty")
      return;
    }

    if (this.createMachineForm.value["description"] == null)
      this.createMachineForm.value["description"] = "";

    console.log(this.createMachineForm.value);
    this.machineService.create(this.createMachineForm.value)
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


}
