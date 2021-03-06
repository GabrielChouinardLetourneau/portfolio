import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

// Components
import { NotFoundComponent } from 'src/app/not-found/not-found.component';
import { HomeComponent } from 'src/app/home/home.component';
import { RealisationIndexComponent } from './realisation-index/realisation-index.component';
import { SandboxComponent } from './sandbox/sandbox.component';
import { TwitchAuthGuard } from './guards/twitchAuth.guard';

const routes: Routes = [
  {
    path: '',
    component: HomeComponent,
    pathMatch: 'full',
  },
  {
    path: 'realisation',
    component: RealisationIndexComponent
  },
  {
    path: 'sandbox',
    component: SandboxComponent,
    canActivate: [TwitchAuthGuard]
  },
  {
    path: '**',
    component: NotFoundComponent
  }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})



export class AppRoutingModule { }
