import { Component, OnInit, Output, EventEmitter } from '@angular/core';

@Component({
  selector: 'header-component',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.scss']
})
export class HeaderComponent implements OnInit {

  @Output() lang = new EventEmitter();

  constructor() { }

  ngOnInit(): void {
  }

}
