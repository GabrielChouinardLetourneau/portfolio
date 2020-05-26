import { Component, OnInit } from '@angular/core';
import { SkillsContent } from './skillsContent';

@Component({
  selector: 'skills-tabs',
  templateUrl: './skills-tabs.component.html',
  styleUrls: ['./skills-tabs.component.scss']
})
export class SkillsTabsComponent implements OnInit {
  public skillsContent;
  public currentContent;
  public titles;

  ngOnInit() {
    this.skillsContent = SkillsContent;

    this.titles = Object.keys(this.skillsContent);
    console.log(this.skillsContent);
  }
}
