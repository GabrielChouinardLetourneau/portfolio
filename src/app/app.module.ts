import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';

import { AppComponent } from './app.component';
import { AngularDocsComponent } from './angular-docs/angular-docs.component';
import { MatTabsModule } from '@angular/material/tabs';

import { HomeComponent } from './home/home.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { MoreAboutMeComponent } from './more-about-me/more-about-me.component';
import { RealisationsComponent } from './realisations/realisations.component';
import { IntroductionComponent } from './introduction/introduction.component';
import { SkillsTabsComponent } from './skills-tabs/skills-tabs.component';
import { AppRoutingModule } from './app.routes';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';

@NgModule({
  declarations: [
    AngularDocsComponent,
    AppComponent,
    HeaderComponent,
    HomeComponent,
    FooterComponent,
    IntroductionComponent,
    RealisationsComponent,
    MoreAboutMeComponent,
    SkillsTabsComponent
  ],
  imports: [
    AppRoutingModule,
    BrowserModule,
    BrowserAnimationsModule,
    MatTabsModule
  ],
  providers: [],
  bootstrap: [AppComponent],
  schemas: [
    CUSTOM_ELEMENTS_SCHEMA
  ]
})
export class AppModule { }
