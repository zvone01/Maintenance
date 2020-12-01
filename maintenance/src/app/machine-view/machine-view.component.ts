import { Component, OnInit } from '@angular/core';
import { Machine } from '../_models';
import { MachineService } from '../_services';
import { Router, CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';

@Component({
  selector: 'app-machine-view',
  templateUrl: './machine-view.component.html',
  styleUrls: ['./machine-view.component.css']
})
export class MachineViewComponent implements OnInit {

  machines: Machine[];

  constructor(private machineService: MachineService, private router: Router) { }

  ngOnInit() {
    this.loadAllMachines();
  }


  private loadAllMachines() {
    this.machineService.getAll()
      .subscribe(x => {
        this.machines = x['machines'];
      });

  };

  private navigateMachine(id) {
    console.log(id);
    this.router.navigate(['/machine/' + id]);
  }



}
