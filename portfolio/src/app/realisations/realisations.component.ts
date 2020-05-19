import { Component, OnInit } from '@angular/core';
import { RealisationsContent } from 'src/app/realisations/realisations.enums';


@Component({
  selector: 'Realisations',
  templateUrl: './realisations.component.html',
  styleUrls: ['./realisations.component.css']
})
export class RealisationsComponent implements OnInit {
  public lang: string;
  private allRealisations: any = RealisationsContent;
  public realisations: any;


  constructor() { }

  ngOnInit(): void {
    this.lang = 'fr';

    this.realisations = this.allRealisations[this.lang];
    console.log(this.realisations);
  }

}
