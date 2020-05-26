
import { NgModule } from '@angular/core';

import { HeaderComponent } from '../header/header.component';
import { IntroductionComponent } from '../introduction/introduction.component';
import { RealisationsComponent } from '../realisations/realisations.component';
import { MoreAboutMeComponent } from '../more-about-me/more-about-me.component';

@NgModule({
  declarations: [
    IntroductionComponent,
    RealisationsComponent,
    MoreAboutMeComponent
  ],
  providers: []
})
export class AppModule { }
