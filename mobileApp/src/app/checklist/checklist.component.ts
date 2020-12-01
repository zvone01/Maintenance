import { Component, OnInit, Inject } from '@angular/core';
import { Checks, Checklisttemplate, Checklist } from '../_models';
import { CheckItemsService, TemplateService, ChecklistService } from '../_services';
import { ActivatedRoute } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { Location } from '@angular/common';

@Component({
  selector: 'app-checklist',
  templateUrl: './checklist.component.html',
  styleUrls: ['./checklist.component.css']
})
export class ChecklistComponent implements OnInit {

  checks: Checks[];
  checksDone: Checks[];
  checklistTemplate: Checklisttemplate = new Checklisttemplate();
  displayedColumns: string[] = ['Name', 'Description', 'Action'];
  //machineID: number;
  constructor(private checksService: CheckItemsService,
              private templateService: TemplateService,
              private checklistService: ChecklistService,
              private route: ActivatedRoute,
              private location: Location,
              private snackBar: MatSnackBar) {

    this.checklistTemplate.ID = parseInt(this.route.snapshot.paramMap.get('id'));
    //this.machineID = parseInt(this.route.snapshot.paramMap.get('m'));

  }

  ngOnInit() {
    this.loadChecks();
    this.loadTemplate();
  }

  private navigateBack() {
    this.location.back();
  }



  private loadTemplate() {
    this.templateService.getByID(this.checklistTemplate.ID)
      .subscribe(x => { this.checklistTemplate = x; });
  }

  private loadChecks() {
    this.checksService.getChecks(this.checklistTemplate.ID)
      .subscribe(x => {
        this.checks = x['checks'];
        this.checksDone = x['checksDone'];
        console.log(this.checks);
      });
  }
  
private save(selectedList: any) {
  let checklist: Checklist[] = [];
  console.log(this.checklistTemplate);

  for (let a of selectedList) {
    let cl: Checklist = new Checklist();
    cl.Machine_ID = this.checklistTemplate.Machine_ID;
    cl.Template_ID = this.checklistTemplate.ID;
    cl.Item_ID = a.value;
    cl.Checked = true;
    cl.Date_Time = new Date();
    cl.Failure_ID = 0;
    cl.Note = '';
    cl.User_ID = 0;

    checklist.push(cl );
  }
  console.log(checklist);
  this.checklistService.save(checklist)
  .subscribe(
/*
    message => {
      console.log(message);
      this.openSnackBar(message);

    },*/
    error => {
      console.log("Error");
      this.openSnackBar("Error");

    });

}

  openSnackBar(message: string) {

    console.log(message);

    this.snackBar.open(message, "Close", {
      duration: 5000,
    });
  }

}
