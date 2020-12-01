import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable} from 'rxjs';
import { Checklisttemplate } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class TemplateService {
  constructor(private http: HttpClient) { }

  getByID(id: number): Observable<Checklisttemplate> {
    return this.http.get<Checklisttemplate>(`${environment.apiUrl}/chekclisttemplate/readOne.php?ID=${id}`);
  }
  getAll(): Observable<Checklisttemplate[]> {
    return this.http.get<Checklisttemplate[]>(`${environment.apiUrl}/chekclisttemplate/read.php`);
  }
  getAllByMachineID(machineId: number): Observable<Checklisttemplate[]> {
    return this.http.get<Checklisttemplate[]>(`${environment.apiUrl}/chekclisttemplate/read.php?Machine_ID=${machineId}`);
  }
  create(machine: Checklisttemplate) {
    return this.http.post(`${environment.apiUrl}/chekclisttemplate/create.php`, machine);
  }

  update(machine: Checklisttemplate) {
    return this.http.post(`${environment.apiUrl}/chekclisttemplate/update.php`, machine);
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/chekclisttemplate/delete.php`, ID);
  }
}
