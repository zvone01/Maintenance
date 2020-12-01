import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Checks } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class CheckItemsService {

  constructor(private http: HttpClient) { }

  getChecks(ID: number): Observable<Checks[]> {
    return this.http.get<Checks[]>(`${environment.apiUrl}/checkitems/readByListID.php?List_ID=` + ID);
  }
  create(checks: Checks) {
    return this.http.post(`${environment.apiUrl}/checkitems/create.php`, checks);
  }
  update(checks: Checks) {
    return this.http.post(`${environment.apiUrl}/checkitems/update.php`, checks);
  }

  delete(ID: number) {
    return this.http.post(`${environment.apiUrl}/checkitems/delete.php`,  ID);
  }

}
