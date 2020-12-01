import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { LoginComponent } from './login/login.component';
import { HomeComponent } from './home/home.component';

import {CheckItemsService, MachineService, TemplateService, UserService} from './_services'

//login
import { AuthGuard } from './_guards';
import { AuthenticationService} from './_services';
import { JwtInterceptor } from './_helpers';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';

//material
import {MatSnackBarModule} from '@angular/material/snack-bar';
import {MatButtonModule} from '@angular/material/button';
import {MatToolbarModule} from '@angular/material/toolbar';
import { MachineComponent } from './machine/machine.component';
import {MatCardModule} from '@angular/material/card';
import {MatListModule} from '@angular/material/list';
import { MachinesComponent } from './machines/machines.component';
import {MatIconModule} from '@angular/material/icon';
import { ChecklistComponent } from './checklist/checklist.component';
import {MatTableModule} from '@angular/material/table';


@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    HomeComponent,
    MachineComponent,
    MachinesComponent,
    ChecklistComponent
  ],
  imports: [
    BrowserModule,
    AppRoutingModule,
    HttpClientModule,
    BrowserAnimationsModule,
    ReactiveFormsModule,
    MatSnackBarModule,
    MatButtonModule,
    MatToolbarModule,
    MatCardModule,
    MatListModule,
    MatIconModule,
    MatTableModule
  ],
  providers: [AuthenticationService, AuthGuard,
    MachineService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    
    TemplateService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
   
    UserService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
   
    CheckItemsService,
    { provide: HTTP_INTERCEPTORS, useClass: JwtInterceptor, multi: true },
    ],
  bootstrap: [AppComponent]
})
export class AppModule { }
