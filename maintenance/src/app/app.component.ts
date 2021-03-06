import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { AlertService, AuthenticationService, UserService } from './_services';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css']
})
export class AppComponent {
  title = 'maintenance';

  constructor(
    private authenticationService: AuthenticationService,
    public router: Router) { }

  logout() {

    this.authenticationService.logout();
    this.router.navigate(["/login"]);

  }
}
