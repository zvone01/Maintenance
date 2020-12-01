import { Component, OnInit } from '@angular/core';
import { Machine } from '../_models';
import { MachineService } from '../_services';
import { Router } from '@angular/router';


@Component({
  selector: 'app-machines',
  templateUrl: './machines.component.html',
  styleUrls: ['./machines.component.css']
})
export class MachinesComponent implements OnInit {

 
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
