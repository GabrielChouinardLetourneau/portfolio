import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'MoreAboutMe',
  templateUrl: './more-about-me.component.html',
  styleUrls: ['./more-about-me.component.scss']
})
export class MoreAboutMeComponent implements OnInit {
  public index;
  
  constructor() { }

  ngOnInit(): void {
  }

  onChange(idx) {
    console.log(idx);
    this.index =  idx;
  }
}
