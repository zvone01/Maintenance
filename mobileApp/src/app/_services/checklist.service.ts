import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Checklist } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class ChecklistService {

  constructor(private http: HttpClient) { }

  save(cheklist: Checklist[]) {
    return this.http.post(`${environment.apiUrl}/checklist/save.php`, cheklist);
  }

}
