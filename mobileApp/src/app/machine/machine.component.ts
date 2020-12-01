import { Component, OnInit, Inject } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { MatSnackBar } from '@angular/material/snack-bar';
import { TemplateService, MachineService } from '../_services';
import { Machine, Checklisttemplate } from '../_models';

@Component({
  selector: 'app-machine',
  templateUrl: './machine.component.html',
  styleUrls: ['./machine.component.css']
})

export class MachineComponent implements OnInit {


  machine: Machine = new Machine();
  templates: Checklisttemplate[];

  constructor(private TemplateService: TemplateService,
              private MachineService: MachineService,
              private route: ActivatedRoute,
              private router: Router) { }


  ngOnInit() {
    console.log(this.route.snapshot.paramMap.get('id'));
    this.machine.ID = parseInt(this.route.snapshot.paramMap.get('id'));
    // this.resetForm();
    this.loadAllTemplates();
    this.getMachine(this.machine.ID);
  }

  openMachineDialog(): void {
  }

  openTemplateDialog(): void {
  }


  private getMachine(id) {
    this.MachineService.readOne(id)
      .subscribe(x => { this.machine.Description = x['Description'], this.machine.Name = x['Name'], console.log(this.machine) });
  }

  private loadAllTemplates() {
    this.TemplateService.getAllByMachineID(this.machine.ID)
      .subscribe(x => {
        this.templates = x['templates'];
      });

  }


  private navigateTemplate(id) {
    console.log(id);
    this.router.navigate(['/checklist/' + id]);
    //this.router.navigate(['/checklist/', id, this.machine.ID]);
  }

  private navigateMachinesV() {
    this.router.navigate(['/machines']);
  }
}
