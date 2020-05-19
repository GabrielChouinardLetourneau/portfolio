import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';

import { AppComponent } from './app.component';
import { AngularDocsComponent } from './angular-docs/angular-docs.component';
import { RealisationIndexComponent } from './realisation-index/realisation-index.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { HomeComponent } from './home/home.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { MoreAboutMeComponent } from './more-about-me/more-about-me.component';
import { RealisationsComponent } from './realisations/realisations.component';
import { IntroductionComponent } from './introduction/introduction.component';

@NgModule({
  declarations: [
    AngularDocsComponent,
    AppComponent,
    HeaderComponent,
    HomeComponent,
    FooterComponent,
    IntroductionComponent,
    RealisationsComponent,
    MoreAboutMeComponent
  ],
  imports: [
    BrowserModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
