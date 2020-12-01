import { Component, OnInit, Inject } from '@angular/core';
import { Checks, Checklisttemplate } from '../_models';
import { CheckItemsService, TemplateService } from '../_services';
import { ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { first } from 'rxjs/operators';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Location } from '@angular/common';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { ConfirmationDialogComponent } from '../components/shared/confirmation-dialog/confirmation-dialog.component';
import { Template } from '@angular/compiler/src/render3/r3_ast';
import { Router } from '@angular/router';

@Component({
  selector: 'app-template-items',
  templateUrl: './template-items.component.html',
  styleUrls: ['./template-items.component.css']
})
export class TemplateItemsComponent implements OnInit {

  checks: Checks[];
  checklistTemplate: Checklisttemplate = new Checklisttemplate();
  createCheckItemForm: FormGroup;
  displayedColumns: string[] = ['Name', 'Description', 'Action'];

  constructor(private checksService: CheckItemsService,
              private templateService: TemplateService,
              private route: ActivatedRoute,
              private location: Location,
              private formBuilder: FormBuilder,
              private snackBar: MatSnackBar,
              public dialog: MatDialog) {

    // tslint:disable-next-line: radix
    this.checklistTemplate.ID = parseInt(this.route.snapshot.paramMap.get('id'));

  }

  ngOnInit() {
    this.resetForm();
    this.loadChecks();
    this.loadTemplate();
  }

  private navigateBack() {
    this.location.back();
  }

  private openTemplateDialog() {
    console.log(this.checklistTemplate);
    const dialogRef = this.dialog.open(TemplateUpdateDialogComponent, {
      width: '500px',
      data: this.checklistTemplate
    });
    dialogRef.afterClosed().subscribe(result => {
      this.loadTemplate();
    });
  }

  private openItemDialog() {
    const dialogRef = this.dialog.open(ItemDialogComponent, {
      width: '500px',
      data: { list_ID: this.checklistTemplate.ID }
    });
    dialogRef.afterClosed().subscribe(result => {
      this.loadChecks();
    });
  }

  private loadTemplate() {
    this.templateService.getByID(this.checklistTemplate.ID)
      .subscribe(x => { this.checklistTemplate = x; });
  }

  private loadChecks() {
    this.checksService.getChecks(this.checklistTemplate.ID)
      .subscribe(x => {
        this.checks = x['checks'];
        console.log(this.checks);
      });
  }
  private openItemEditDialog(id: number) {
    console.log(this.checks.find(x => x.ID === id));
    const dialogRef = this.dialog.open(ItemDialogComponent, {
      width: '500px',
      data: { list_ID: this.checklistTemplate.ID, item: this.checks.find(x => x.ID === id) }
    });
    dialogRef.afterClosed().subscribe(result => {
      this.loadChecks();
    });
  }

  private deleteItem(item: Checks) {
    console.log(item);

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
      width: '250px',
      data: "Jeste li sigurni da želite izbrisati: " + item.Name + " ? "
    });

    dialogRef.afterClosed().subscribe( result => {
      if (result) {
        console.log('yes');
        this.checksService.delete(item.ID)
        .pipe(first())
        .subscribe(
          data => {
            this.openSnackBar(data['message'])
            this.loadChecks();
          },
          error => {
            console.log("Error");
            this.openSnackBar("Error")
          });
      } else {
        console.log('no');
      }
    });
  }


  resetForm() {
    this.createCheckItemForm = this.formBuilder.group({
      Name: [null, Validators.required],
      listID: [this.checklistTemplate.ID],
      Description: [null],
      Unit_of_measure: [null]

    });
  }

  openSnackBar(message: string) {

    console.log(message);

    this.snackBar.open(message, "Close", {
      duration: 5000,
    });
  }



}



////////////////////////////////////////////////////////////////
///// Dialog Item
////////////////////////////////////////////////////////////
@Component({
  selector: 'app-item-dialog',
  templateUrl: 'item-dialog.html',
})
export class ItemDialogComponent {

  createCheckItemForm: FormGroup;

  constructor(
    public dialogRef: MatDialogRef<ItemDialogComponent>,
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    private checksService: CheckItemsService,
    @Inject(MAT_DIALOG_DATA) public data: any) {
    console.log('create dialog');
    this.resetForm();
  }

  resetForm() {
    if (this.data.item) {
      this.createCheckItemForm = this.formBuilder.group({
        Name: [this.data.item.Name, Validators.required],
        listID: [this.data.list_ID],
        Description: [this.data.item.Description],
        Unit_of_measure: ["bool"],
        ID: [this.data.item.ID],

      });
    } else {
      this.createCheckItemForm = this.formBuilder.group({
        Name: [null, Validators.required],
        listID: [this.data.list_ID],
        Description: [null],
        Unit_of_measure: ["bool"]
      })
    }
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  openSnackBar(message: string) {
    this.snackBar.open(message, 'Close', {
      duration: 5000,
    });
  }

  onSubmit() {
    // this.submitted = true;
    if (this.createCheckItemForm.invalid) {
      
      this.openSnackBar("Form error")
      return;
    }

    if (this.createCheckItemForm.value["Description"] == null) {
      this.createCheckItemForm.value["Description"] = "";
    }

    if (this.createCheckItemForm.value[" Unit_of_measure"] == null)
      this.createCheckItemForm.value["Unit_of_measure"] = "";

    console.log(this.createCheckItemForm.value);
    if (this.data.item) {
      console.log(this.createCheckItemForm.value);
      this.checksService.update(this.createCheckItemForm.value)
      .pipe(first())
      .subscribe(

        data => {
          console.log(data["message"]);
          this.openSnackBar(data["message"])
          this.onNoClick();

        },
        error => {
          console.log("Error");
          this.openSnackBar("Error")

        });
    } else {
      this.checksService.create(this.createCheckItemForm.value)
      .pipe(first())
      .subscribe(

        data => {
          console.log(data["message"]);
          this.openSnackBar(data["message"])
          this.onNoClick();

        },
        error => {
          console.log("Error");
          this.openSnackBar("Error")

        });

    }
    

  }
}




////////////////////////////////////////////////////////////////
///// Dialog Template
////////////////////////////////////////////////////////////
@Component({
  selector: 'app-template-dialog',
  templateUrl: 'template-dialog.html',
})
export class TemplateUpdateDialogComponent {

  updateTemplateForm: FormGroup;

  constructor(
    public dialogRef: MatDialogRef<ItemDialogComponent>,
    private formBuilder: FormBuilder,
    private snackBar: MatSnackBar,
    private templateService: TemplateService,
    public dialog: MatDialog,
    private router: Router,
    @Inject(MAT_DIALOG_DATA) public template: Checklisttemplate) {
    this.resetForm();
  }

  resetForm() {
    this.updateTemplateForm = this.formBuilder.group({
      Name: [this.template.Name, Validators.required],
      Machine_ID: [this.template.Machine_ID],
      Frequency: [this.template.Frequency],
      ID: [this.template.ID]

    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  openSnackBar(message: string) {
    this.snackBar.open(message, 'Close', {
      duration: 5000,
    });
  }

  onSubmit() {
    // this.submitted = true;
    if (this.updateTemplateForm.invalid) {
      
      this.openSnackBar("Form error")
      return;
    }

    if (this.updateTemplateForm.value["Frequency"] == null) {
      this.updateTemplateForm.value["Frequency"] = "";
    }

    this.templateService.update(this.updateTemplateForm.value)
      .pipe(first())
      .subscribe(

        data => {
          console.log(data["message"]);
          this.openSnackBar(data["message"])
          this.onNoClick();

        },
        error => {
          console.log("Error");
          this.openSnackBar("Error")

        });

  }

  private delete() {
    console.log(this.template);

    const dialogRef = this.dialog.open(ConfirmationDialogComponent, {
      width: '250px',
      data: "Jeste li sigurni da želite izbrisati: " + this.template.Name + " ? "
    });

    dialogRef.afterClosed().subscribe( result => {
      if (result) {
        console.log('yes');
        this.templateService.delete(this.template.ID)
        .pipe(first())
        .subscribe(
          data => {
            this.openSnackBar(data['message'])
            //navigate to machine
            this.onNoClick();
            this.router.navigate(['machine/' + this.template.Machine_ID]);
          },
          error => {
            console.log("Error");
            this.openSnackBar("Error")
          });
      } else {
        console.log('no');
      }
    });
  }
}
