import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { Machine } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class MachineService {

  constructor(private http: HttpClient) { }

  getAll(): Observable<Machine[]> {
    return this.http.get<Machine[]>(`${environment.apiUrl}/machine/read.php`);
  }

  readOne(ID: number) {
    return this.http.get(`${environment.apiUrl}/machine/readOne.php?ID=${ID}`);
  }


}
