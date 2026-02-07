# Deployment Checklist - Daftar 1 Digital Lebak Wangi

## Pre-Deployment

- [ ] Verify all tests pass
- [ ] Confirm .env.example is up-to-date
- [ ] Update version numbers if applicable
- [ ] Prepare release notes
- [ ] Backup current production database
- [ ] Ensure all migrations are ready

## Server Preparation

- [ ] Server meets minimum requirements (PHP 8.1+, MySQL 8.0+)
- [ ] Composer is installed
- [ ] Git is installed
- [ ] Web server (Apache/Nginx) is configured
- [ ] SSL certificate is ready
- [ ] Domain name is pointing to server
- [ ] Firewall rules are configured

## Application Deployment

- [ ] Clone/pull latest code to server
- [ ] Run `composer install --no-dev --optimize-autoloader`
- [ ] Copy .env file with production settings
- [ ] Generate application key with `php artisan key:generate`
- [ ] Run database migrations with `php artisan migrate --force`
- [ ] Seed database if needed with `php artisan db:seed --force`
- [ ] Clear and cache configuration with `php artisan config:cache`
- [ ] Clear and cache routes with `php artisan route:cache`
- [ ] Set proper file permissions
- [ ] Create storage symlink with `php artisan storage:link`

## Post-Deployment

- [ ] Verify application loads correctly
- [ ] Test user authentication
- [ ] Verify all major features work
- [ ] Test admin panel access
- [ ] Verify school-specific access controls
- [ ] Test Excel import/export functionality
- [ ] Test report generation
- [ ] Verify automated tasks (cron jobs) are working
- [ ] Monitor application logs for errors
- [ ] Update DNS if needed

## Security Checks

- [ ] Verify APP_DEBUG is set to false
- [ ] Confirm sensitive data is not exposed
- [ ] Check file upload restrictions
- [ ] Verify role-based access controls work
- [ ] Test XSS and CSRF protections
- [ ] Confirm HTTPS is enforced

## Performance Optimization

- [ ] Enable OPcache
- [ ] Configure Redis for caching (if available)
- [ ] Optimize database indexes
- [ ] Minify CSS/JS assets
- [ ] Configure CDN if available
- [ ] Set up monitoring tools

## Monitoring & Maintenance

- [ ] Set up error logging
- [ ] Configure backup schedule
- [ ] Set up uptime monitoring
- [ ] Schedule regular maintenance windows
- [ ] Configure automated security updates
- [ ] Set up performance monitoring

## Rollback Plan

- [ ] Database backup available
- [ ] Previous version code available
- [ ] Rollback procedure documented
- [ ] Contact information for team members

## Final Verification

- [ ] Application URL: https://daftar1.lebakwangi.sch.id
- [ ] Admin panel accessible
- [ ] All user roles working correctly
- [ ] Data import/export functioning
- [ ] Reports generating correctly
- [ ] Automated tasks running
- [ ] Security measures in place
- [ ] Performance acceptable

## Post-Launch

- [ ] Monitor for first 24 hours
- [ ] Collect user feedback
- [ ] Document any issues
- [ ] Schedule follow-up review
- [ ] Update documentation if needed