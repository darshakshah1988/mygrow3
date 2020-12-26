import * as slug from 'slug'
import { Table, Column, Model, ForeignKey, BelongsTo,  Scopes } from 'sequelize-typescript'
import File from './File'
import Course from './Course';

@Scopes({
  includeFiles: {
    include: [{
      model: () => File,
      as: 'media'
    }]
  }
})

@Table({ timestamps: true })
export class Sponsor extends Model<Sponsor> {
    @Column({ primaryKey: true, autoIncrement: true })
    id: number
  
    @Column name: string
    @Column message: string
    @Column website: string

    @ForeignKey(()=>Course)
    @Column
    courseId :number
    @BelongsTo(() => File, 'courseId')
    course: Course

    @ForeignKey(() => File)
    @Column
    logo: string
    @BelongsTo(() => File, 'logo')
    media: File
}

export default Sponsor
