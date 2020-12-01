import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { environment } from '../../environments/environment';
import { Observable } from 'rxjs';
import { UserTypes, User } from '../_models';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor(private http: HttpClient) { }

  getAllTypes(): Observable<UserTypes[]> {
    return this.http.get<UserTypes[]>(`${environment.apiUrl}/user/getusertypes.php`);
  }

  getAll(): Observable<User[]> {
    return this.http.get<User[]>(`${environment.apiUrl}/user/read.php`);
  }

  create(user: User) {
    return this.http.post(`${environment.apiUrl}/user/create.php`, user);
  }

  checkToken() {
    return this.http.post(`${environment.apiUrl}/user/checktoken.php`,'');
}


}
