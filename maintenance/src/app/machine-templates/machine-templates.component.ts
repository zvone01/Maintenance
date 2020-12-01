import { Component, OnInit, Inject } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { first } from 'rxjs/operators';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { MatSnackBar } from '@angular/material/snack-bar';
import { MatDialog, MatDialogRef, MAT_DIALOG_DATA } from '@angular/material/dialog';
import { TemplateService, MachineService } from '../_services';
import { Machine, Checklisttemplate } from '../_models';

@Component({
  selector: 'app-machine-templates',
  templateUrl: './machine-templates.component.html',
  styleUrls: ['./machine-templates.component.css']
})
export class MachineTemplatesComponent implements OnInit {

  machine: Machine = new Machine();
  machines: Machine[];
  templates: Checklisttemplate[];

  constructor(private templateService: TemplateService,
              private machineService: MachineService,
              private route: ActivatedRoute,
              private formBuilder: FormBuilder,
              private _snackBar: MatSnackBar,
              private router: Router,
              public dialog: MatDialog) { }


  ngOnInit() {
    console.log(this.route.snapshot.paramMap.get('id'));
    this.machine.ID = parseInt(this.route.snapshot.paramMap.get('id'));
    // this.resetForm();
    this.loadAllTemplates();
    this.getMachine(this.machine.ID);
    this.loadAllMachines();
    console.log(this.machine);
  }

  
  private loadAllMachines() {
    this.machineService.getAll()
      .subscribe(x => {
        this.machines = x['machines'];
      });

  };

  private navigateMachine(id) {
    this.router.navigate(['/machine/' + id]);
  }

  openMachineDialog(): void {
    const dialogRef = this.dialog.open(MachineDialogComponent, {
      width: '250px',
      data: this.machine
    });
    dialogRef.afterClosed().subscribe(result => {
      this.getMachine(this.machine.ID);
    });
  }

  openTemplateDialog(): void {
    const dialogRef = this.dialog.open(TemplateDialogComponent, {
      width: '250px',
      data: this.machine.ID
    });
    dialogRef.afterClosed().subscribe(result => {
      this.loadAllTemplates();
    });
  }


  private getMachine(id) {
    this.machineService.readOne(id)
      .subscribe(x => { this.machine.Description = x['Description'], this.machine.Name = x['Name'] });
  }

  private loadAllTemplates() {
    this.templateService.getAllByMachineID(this.machine.ID)
      .subscribe(x => {
        this.templates = x['templates'];
      });

  }


  private navigateTemplate(id) {
    console.log(id);
    this.router.navigate(['/templateI/' + id]);
  }

  private navigateMachinesV() {
    this.router.navigate(['/machinesV']);
  }
  /*
    openSnackBar(message: string) {
      this._snackBar.open(message, 'Close', {
        duration: 5000,
      });
    }*/
}

////////////////////////////////////////////////////////////////
///// Dialog Template
////////////////////////////////////////////////////////////
@Component({
  selector: 'app-template-dialog',
  templateUrl: 'template-dialog.html',
})
export class TemplateDialogComponent {

  createTemplateForm: FormGroup;

  constructor(
    public dialogRef: MatDialogRef<TemplateDialogComponent>,
    private formBuilder: FormBuilder,
    private _snackBar: MatSnackBar,
    private templateService: TemplateService,
    @Inject(MAT_DIALOG_DATA) public data: number) {
    console.log('create dialog');
    this.resetTemplateForm();
  }

  resetTemplateForm() {
    this.createTemplateForm = this.formBuilder.group({
      Name: [null, Validators.required],
      Frequency: [null],
      Machine_ID: [this.data]
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  onItemChange(str): void{

    if (str.target.value == "dnevno")
      this.createTemplateForm.value["Frequency"] = 1
       else if (str.target.value == "mjesecno") 
       this.createTemplateForm.value["Frequency"] = 2
       else if (str.target.value == "godisnje") 
       this.createTemplateForm.value["Frequency"] = 3

       console.log(this.createTemplateForm.value["Frequency"]);
  }
  

  openSnackBar(message: string) {
    this._snackBar.open(message, 'Close', {
      duration: 5000,
    });
  }

  onSubmitTemplate() {
    // this.submitted = true;
    if (this.createTemplateForm.invalid) {
      console.log('Name empty');
      this.openSnackBar('Name empty');
      return;
    }
    if (this.createTemplateForm.value['Frequency'] == null)
      this.createTemplateForm.value['Frequency'] = 1;
      
    console.log(this.createTemplateForm.value);
    this.templateService.create(this.createTemplateForm.value)
      .pipe(first())
      .subscribe(

        data => {
          console.log(data['message']);
          this.openSnackBar(data['message'])
          this.onNoClick();
        },
        error => {
          console.log('Error');
          this.openSnackBar('Error');
        });
  }
}

////////////////////////////////////////////////////////////////
///// Dialog Machine
////////////////////////////////////////////////////////////
@Component({
  selector: 'app-machine-dialog',
  templateUrl: 'machine-dialog.html',
})
export class MachineDialogComponent {

  updateMachineForm: FormGroup;

  constructor(
    public dialogRef: MatDialogRef<MachineDialogComponent>,
    private formBuilder: FormBuilder,
    private _snackBar: MatSnackBar,
    private machineService: MachineService,
    @Inject(MAT_DIALOG_DATA) public machine: Machine) {
    console.log('create dialog');
    this.resetMachineForm();
  }

  resetMachineForm() {
    this.updateMachineForm = this.formBuilder.group({
      Name: [this.machine.Name],
      Description: [this.machine.Description],
      ID: [this.machine.ID]
    });
  }

  onNoClick(): void {
    this.dialogRef.close();
  }

  openSnackBar(message: string) {
    this._snackBar.open(message, 'Close', {
      duration: 5000,
    });
  }


  onSubmitMachine() {
    // this.submitted = true;
    if (this.updateMachineForm.invalid) {
      console.log('Name empty');
      this.openSnackBar('Name empty');
      return;
    }

    if (this.updateMachineForm.value['Description'] == null) {
      this.updateMachineForm.value['updateMachineForm'] = '';
    }

    console.log(this.updateMachineForm.value);
    this.machineService.update(this.updateMachineForm.value)
      .pipe(first())
      .subscribe(

        data => {
          console.log(data['message']);
          this.openSnackBar(data['message'])
          this.onNoClick();
        },
        error => {
          console.log('Error');
          this.openSnackBar('Error');
        });

  }
}
