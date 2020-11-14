import { BrowserModule } from '@angular/platform-browser';
import { NgModule, CUSTOM_ELEMENTS_SCHEMA } from '@angular/core';

import { AppComponent } from './app.component';
import { AngularDocsComponent } from './angular-docs/angular-docs.component';
import { MatTabsModule } from '@angular/material/tabs';
import { MatButtonModule } from '@angular/material/button';
import { HttpClientModule } from '@angular/common/http';
import {MatInputModule} from '@angular/material/input';
import { HomeComponent } from './home/home.component';
import { HeaderComponent } from './header/header.component';
import { FooterComponent } from './footer/footer.component';
import { MoreAboutMeComponent } from './more-about-me/more-about-me.component';
import { RealisationsComponent } from './realisations/realisations.component';
import { IntroductionComponent } from './introduction/introduction.component';
import { SkillsTabsComponent } from './skills-tabs/skills-tabs.component';
import { AppRoutingModule } from './app.routes';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { BackendService } from './backend/backend.service';
import { SandboxComponent } from './sandbox/sandbox.component';
import { ReactiveFormsModule } from '@angular/forms';
import {MatCardModule} from '@angular/material/card';
import { SanitizePipe } from './sandbox/sanitize.pipe';

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
    SandboxComponent,
    SkillsTabsComponent,
    SanitizePipe
  ],
  imports: [
    AppRoutingModule,
    BrowserModule,
    BrowserAnimationsModule,
    MatTabsModule,
    MatButtonModule,
    HttpClientModule,
    MatInputModule,
    ReactiveFormsModule,
    MatCardModule
  ],
  providers: [
    BackendService
  ],
  bootstrap: [AppComponent],
  schemas: [
    CUSTOM_ELEMENTS_SCHEMA
  ]
})
export class AppModule { }
