### Creating your own REST API services in bitrix24

### Usage
- install module
- Create incoming webhook in `/devops/` with `mtai` scope
- Register your service class in `\MTai\Services\Rest\ServiceRegister::onRestServiceBuildDescription()`

### Examples of services in the module
- `mtai.department.add`, `mtai.department.update`, `mtai.department.get` - an analogue of the existing bitri24 department services, but with allowing to write to UF_* fields and XML_ID
- `mtai.user.add`, `mtai.user.update`, `mtai.user.get` - analogue of the bitri24 user services, but with allowing to write to UF_* fields
