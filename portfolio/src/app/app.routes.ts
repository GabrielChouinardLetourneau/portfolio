import { Injectable } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

// Components
import { NotFoundComponent } from 'src/app/not-found/not-found.component';
import { HomeComponent } from 'src/app/home/home.component';
import { RealisationsNames } from './realisations/realisations.enums';

@Injectable({
  providedIn: 'root'
})
export class AppRoutes {
  private appRoutes: Routes = [
    { path: '', component: HomeComponent, pathMatch: 'full' },
    { path: '/realisations/:name', data: { realisationsId: "" } },
    { path: '**', component: NotFoundComponent }
  ];

}