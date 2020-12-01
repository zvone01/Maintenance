import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './_guards/index';
import { HomeComponent } from './home';
import { LoginComponent } from './login';
import { MachineComponent } from './machine';
import { MachinesComponent } from './machines';
import { ChecklistComponent } from './checklist';

const routes: Routes = [
  { path: '', component: HomeComponent, canActivate: [AuthGuard]},
  { path: 'login', component: LoginComponent },
  { path: 'machines', component: MachinesComponent, canActivate: [AuthGuard]},
  { path: 'machine/:id', component: MachineComponent, canActivate: [AuthGuard]},
  //{ path: 'checklist/:id/:m', component: ChecklistComponent, canActivate: [AuthGuard]},
  { path: 'checklist/:id', component: ChecklistComponent, canActivate: [AuthGuard]},
  { path: '**', redirectTo: '' }
];
@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
