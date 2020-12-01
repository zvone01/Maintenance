import { Component, OnInit } from '@angular/core';
import { UserService } from '../_services';
import { User, UserTypes } from '../_models';

@Component({
  selector: 'app-user-view',
  templateUrl: './user-view.component.html',
  styleUrls: ['./user-view.component.css']
})
export class UserViewComponent implements OnInit {

  users: User[];
  userTypes: UserTypes[];
  
  constructor(private userService: UserService) { }

  ngOnInit() {
    this.loadAllUserTypes();
    this.loadAllUsers();
  }

  private loadAllUserTypes() {
    this.userService.getAllTypes()
      .subscribe(x => {
        this.userTypes = x['usertypes'];
        console.log(this.userTypes);
      });

  
  };

  private loadAllUsers() {
    this.userService.getAll()
      .subscribe(x => {
        this.users = x['users'];
        console.log(this.users);
      });

  };

}
